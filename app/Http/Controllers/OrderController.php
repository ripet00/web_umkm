<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function __construct() {
        // Set konfigurasi Midtrans
        // Pastikan Anda sudah mengatur variabel-variabel ini di config/midtrans.php
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    # Menampilkan halaman checkout
    public function checkout() {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong!');
        }

        return view('orders.checkout', compact('cart'));
    }

    # Memproses pesanan dan membuat transaksi Midtrans
    public function process(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('items.product.seller')->where('user_id', $user->id)->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item di keranjang untuk di-checkout.');
        }
        
        // Kelompokkan item berdasarkan seller_id
        $itemsBySeller = $cart->items->groupBy('product.seller_id');

        // Gunakan DB Transaction untuk memastikan integritas data
        $orders = DB::transaction(function () use ($user, $itemsBySeller) {
            $createdOrders = [];
            foreach ($itemsBySeller as $sellerId => $items) {
                // Hitung total harga per penjual
                $totalPerSeller = $items->sum(function ($item) {
                    return $item->quantity * $item->product->harga;
                });

                // Buat pesanan baru untuk setiap penjual
                $order = Order::create([
                    'user_id' => $user->id,
                    'seller_id' => $sellerId, // Menggunakan seller_id yang benar
                    'nomor_pesanan' => 'ORD-' . Str::uuid(),
                    'total_harga' => $totalPerSeller,
                    'status' => 'unpaid',
                ]);

                // Pindahkan item dari keranjang ke item pesanan
                foreach ($items as $item) {
                    // Cek stok sebelum membuat pesanan
                    if ($item->product->stok < $item->quantity) {
                        // Jika stok tidak cukup, batalkan transaksi
                        throw new \Exception('Stok untuk produk ' . $item->product->nama_produk . ' tidak mencukupi.');
                    }

                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'harga' => $item->product->harga,
                    ]);
                }
                $createdOrders[] = $order;
            }

            return $createdOrders;
        });

        // Karena sekarang bisa ada beberapa pesanan, kita akan redirect ke halaman riwayat pesanan
        // Di aplikasi nyata, Anda mungkin ingin membuat satu sesi pembayaran untuk semua pesanan,
        // tapi untuk saat ini, kita akan buat terpisah agar lebih sederhana.
        // Untuk contoh ini, kita ambil pesanan pertama untuk proses pembayaran.
        $mainOrder = $orders[0];

        // Buat transaksi ke Midtrans untuk pesanan utama
        $midtrans_params = [
            'transaction_details' => [
                'order_id' => $mainOrder->nomor_pesanan,
                'gross_amount' => $mainOrder->total_harga,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email' => $user->email,
                'phone' => $user->no_hp,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($midtrans_params);
            $mainOrder->snap_token = $snapToken;
            $mainOrder->save();

            // Kosongkan keranjang setelah pesanan berhasil dibuat
            $cart->items()->delete();

            return view('orders.payment', compact('snapToken', 'mainOrder'));

        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', 'Gagal membuat sesi pembayaran: ' . $e->getMessage());
        }
    }


    # Callback dari Midtrans
    public function handleMidtransNotification(Request $request)
    {
        $notification_payload = $request->all();
        $orderId = $notification_payload['order_id'];
        $statusCode = $notification_payload['status_code'];
        $grossAmount = $notification_payload['gross_amount'];
        $signatureKey = $notification_payload['signature_key'];
        $serverKey = config('midtrans.server_key');

        // Verifikasi signature
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('nomor_pesanan', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status pesanan berdasarkan notifikasi
        $transactionStatus = $notification_payload['transaction_status'];
        $fraudStatus = $notification_payload['fraud_status'];

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                // Pembayaran berhasil
                $this->processSuccessfulPayment($order);
            }
        } else if ($transactionStatus == 'settlement') {
            // Pembayaran berhasil
            $this->processSuccessfulPayment($order);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            // Pembayaran gagal
            $order->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Notification processed']);
    }

    protected function processSuccessfulPayment(Order $order)
    {
        // Gunakan transaction untuk memastikan semua proses berhasil
        DB::transaction(function () use ($order) {
            if ($order->status == 'unpaid') {
                $order->update(['status' => 'paid']);

                // Kurangi stok produk
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    $product->decrement('stok', $item->quantity);
                }

                // Tidak perlu lagi mengosongkan keranjang di sini karena sudah dilakukan setelah checkout
            }
        });
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat order miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->load('items.product.seller');
        return view('orders.show', compact('order'));
    }
}

