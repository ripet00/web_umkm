<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Services\EQBRBlockchainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    protected $blockchainService;

    public function __construct(EQBRBlockchainService $blockchainService) {
        $this->blockchainService = $blockchainService;
        
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout() {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong!');
        }

        return view('orders.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('items.product.seller')->where('user_id', $user->id)->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item di keranjang untuk di-checkout.');
        }
        
        // Cek apakah semua seller sudah aktif
        $itemsBySeller = $cart->items->groupBy('product.seller_id');
        foreach ($itemsBySeller as $sellerId => $items) {
            $seller = $items->first()->product->seller;
            if (!$seller->isActivated()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Seller "' . $seller->nama_koperasi . '" belum mengaktifkan akun Midtrans. Silakan hubungi seller untuk aktivasi.');
            }
        }

        try {
            $orders = DB::transaction(function () use ($user, $itemsBySeller) {
                $createdOrders = [];
                foreach ($itemsBySeller as $sellerId => $items) {
                    $totalPerSeller = $items->sum(function ($item) {
                        return $item->quantity * $item->product->harga;
                    });

                    $order = Order::create([
                        'user_id' => $user->id,
                        'seller_id' => $sellerId,
                        'order_number' => 'ORD-' . Str::uuid(),
                        'total_price' => $totalPerSeller,
                        'status' => 'pending',
                        'payment_status' => 'unpaid',
                        'payment_gateway' => 'midtrans',
                    ]);

                    foreach ($items as $item) {
                        if ($item->product->stok < $item->quantity) {
                            throw new \Exception('Stok untuk produk ' . $item->product->nama_produk . ' tidak mencukupi.');
                        }

                        $order->items()->create([
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->product->harga,
                        ]);
                    }
                    $createdOrders[] = $order;
                }

                return $createdOrders;
            });
            
            $mainOrder = $orders[0];
            $seller = $mainOrder->seller;

            // Validasi bahwa seller memiliki konfigurasi Midtrans lengkap
            if (!$seller->client_key || !$seller->server_key) {
                throw new \Exception('Seller belum mengkonfigurasi Client Key dan Server Key Midtrans.');
            }

            // Gunakan konfigurasi Midtrans dari seller
            Config::$serverKey = $seller->server_key;
            Config::$clientKey = $seller->client_key;
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $midtrans_params = [
                'transaction_details' => [
                    'order_id' => $mainOrder->order_number,
                    'gross_amount' => (int) $mainOrder->total_price,
                ],
                'customer_details' => [
                    'first_name' => $user->nama,
                    'email' => $user->email,
                    'phone' => $user->no_hp,
                ],
                // URL Configuration untuk Midtrans
                'callbacks' => [
                    'finish' => route('orders.show', $mainOrder) . '?status=success',
                    'error' => route('orders.show', $mainOrder) . '?status=error',
                    'unfinish' => route('orders.show', $mainOrder) . '?status=pending',
                ],
                // Informasi seller untuk tracking
                'custom_field1' => $seller->merchant_id,
                'custom_field2' => 'seller_payment_' . $seller->id,
                'custom_field3' => $seller->nama_koperasi,
            ];

            $snapToken = Snap::getSnapToken($midtrans_params);
            $mainOrder->snap_token = $snapToken;
            $mainOrder->client_key = $seller->client_key; // Simpan client key untuk frontend
            $mainOrder->save();

            return view('orders.payment', ['snapToken' => $snapToken, 'order' => $mainOrder]);

        } catch (\Exception $e) {
            return redirect()->route('orders.checkout')->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        // Log untuk debugging
        Log::info('Midtrans notification received', [
            'payload' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        $notification_payload = $request->all();
        $orderId = $notification_payload['order_id'];
        $statusCode = $notification_payload['status_code'];
        $grossAmount = 
        $notification_payload['gross_amount'];
        $signatureKey = $notification_payload['signature_key'];

        // Ambil order untuk mendapatkan seller-specific server key
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::error('Order not found for notification', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Gunakan server key dari seller yang sesuai
        $serverKey = $order->seller->server_key;

        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $signatureKey) {
            Log::error('Invalid signature for notification', [
                'order_id' => $orderId,
                'expected' => $signature,
                'received' => $signatureKey
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $notification_payload['transaction_status'];
        $fraudStatus = $notification_payload['fraud_status'];

        Log::info('Processing transaction status', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus
        ]);

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($fraudStatus == 'accept') {
                $this->processSuccessfulPayment($order);
            }
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'Notification processed successfully']);
    }

    protected function processSuccessfulPayment(Order $order)
    {
        DB::transaction(function () use ($order) {
            if ($order->payment_status == 'unpaid') {
                $order->update(['payment_status' => 'paid', 'status' => 'processing']);

                foreach ($order->items as $item) {
                    Product::find($item->product_id)->decrement('stok', $item->quantity);
                }
                
                $cart = Cart::where('user_id', $order->user_id)->first();
                if($cart) {
                    $orderedProductIds = $order->items->pluck('product_id');
                    $cart->items()->whereIn('product_id', $orderedProductIds)->delete();
                }

                // Hash transaksi ke blockchain EQBR setelah pembayaran berhasil
                $this->hashOrderToBlockchain($order);
            }
        });
    }

    /**
     * Hash order ke blockchain EQBR
     */
    private function hashOrderToBlockchain(Order $order): void
    {
        try {
            // Set status blockchain sebagai pending
            $order->update(['blockchain_status' => 'pending']);

            Log::info('Starting blockchain hash for order', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

            $result = $this->blockchainService->hashTransaction($order);
            
            if ($result['success']) {
                $order->update([
                    'blockchain_hash' => $result['blockchain_hash'],
                    'blockchain_transaction_id' => $result['transaction_id'],
                    'block_number' => $result['block_number'],
                    'transaction_data_hash' => $result['local_hash'],
                    'blockchain_metadata' => [
                        'network_id' => $result['network_id'] ?? null,
                        'raw_response' => $result['raw_response'] ?? null,
                        'hashed_at' => now()->toISOString(),
                    ],
                    'blockchain_created_at' => now(),
                    'blockchain_status' => 'confirmed',
                ]);
                
                Log::info('Order successfully hashed to blockchain', [
                    'order_id' => $order->id,
                    'blockchain_hash' => $result['blockchain_hash'],
                    'transaction_id' => $result['transaction_id']
                ]);
            } else {
                $order->update([
                    'blockchain_status' => 'failed',
                    'blockchain_metadata' => [
                        'error' => $result['error'] ?? 'Unknown error',
                        'failed_at' => now()->toISOString(),
                    ]
                ]);
                
                Log::error('Failed to hash order to blockchain', [
                    'order_id' => $order->id,
                    'error' => $result['error'] ?? 'Unknown error'
                ]);
            }
        } catch (\Exception $e) {
            $order->update([
                'blockchain_status' => 'failed',
                'blockchain_metadata' => [
                    'exception' => $e->getMessage(),
                    'failed_at' => now()->toISOString(),
                ]
            ]);
            
            Log::error('Blockchain hashing exception', [
                'order_id' => $order->id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    // HALAMAN RIWAYAT PESANAN USER
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->with('items.product')
                        ->latest() // Mengurutkan dari yang terbaru
                        ->paginate(10); // Menggunakan paginasi
        return view('orders.index', compact('orders'));
    }

    // HALAMAN DETAIL PESANAN USER
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->load('items.product.seller');
        return view('orders.show', compact('order'));
    }
}

