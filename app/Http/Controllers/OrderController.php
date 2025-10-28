<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function __construct() {
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

            // Gunakan Merchant ID dari seller untuk pembayaran
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
                // Tambahkan merchant ID untuk split payment
                'custom_field1' => $seller->merchant_id, // Merchant ID seller
                'custom_field2' => 'seller_payment', // Identifier untuk payment ke seller
            ];

            $snapToken = Snap::getSnapToken($midtrans_params);
            $mainOrder->snap_token = $snapToken;
            $mainOrder->save();

            return view('orders.payment', ['snapToken' => $snapToken, 'order' => $mainOrder]);

        } catch (\Exception $e) {
            return redirect()->route('orders.checkout')->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    public function handleMidtransNotification(Request $request)
    {
        $notification_payload = $request->all();
        $orderId = $notification_payload['order_id'];
        $statusCode = $notification_payload['status_code'];
        $grossAmount = $notification_payload['gross_amount'];
        $signatureKey = $notification_payload['signature_key'];
        $serverKey = config('midtrans.server_key');

        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $notification_payload['transaction_status'];
        $fraudStatus = $notification_payload['fraud_status'];

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($fraudStatus == 'accept') {
                $this->processSuccessfulPayment($order);
            }
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'Notification processed']);
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
            }
        });
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

