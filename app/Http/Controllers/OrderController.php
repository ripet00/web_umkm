<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct() {
        // Set konfigurasi Midtrans
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
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }
        return view('orders.checkout', compact('cart'));
    }

    # Memproses pesanan dan membuat transaksi Midtrans
    public function process(Request $request) {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Gunakan transaksi database untuk memastikan konsistensi data
        DB::beginTransaction(); 

        try {
            // 1 Buat pesanan baru
            $order = Order::create([
                'user_id' => $user->id,
                'total_harga' => 0, // Akan diupdate nanti
                'status' => 'pending',
            ]);

            $totalPrice = 0;

            // 2 Pindahkan item dari keranjang ke item pesanan
            foreach ($cart->items as $item) {
                // Cek stok lagi untuk keamanan
                if ($item->product->stok < $item->quantity) {
                    throw new \Exception('Stok untuk produk' . $item->product->nama_produk . ' tidak mencukupi.');
                }

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'harga' => $item->product->harga,
                ]);

                $totalPrice += $item->product->harga * $item->quantity;
            }

            // 3 Update total harga pesanan
            $order->update(['total_harga' => $totalPrice]);

            // 4 Siapkan detail untuk Midtrans
            $transaction_details = [
                'order_id' => $order->id . '-' . time(), // ID unik
                'gross_amount' => $totalPrice,
            ];

            $customer_details = [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->no_hp,
            ];

            $params = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            ];

            // 5. Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan snap token ke pesanan untuk referensi
            $order->update(['snap_token' => $snapToken]);

            // Jika semua berhasil, commit transaksi database
            DB::commit();

            return view('orders.payment', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            // Jika ada error, rollback transaksi database
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    # Menangani callback dari Midtrans
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $orderId = explode('-', $request->order_id)[0];
                $order = Order::find($orderId);

                if ($order && $order->status == 'pending') {
                    // Update status pesanan
                    $order->update(['status' => 'paid']);

                    // Kurangi stok produk
                    foreach ($order->items as $item) {
                        $product = Product::find($item->product_id);
                        $product->decrement('stok', $item->quantity);
                    }

                    // Kosongkan keranjang pengguna
                    $user = $order->user;
                    if ($user->cart) {
                        $user->cart->items()->delete();
                    }
                }
            }
        }
    }

    # Menampilkan riwayat pesanan pengguna
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    # Menampilkan detail pesanan
    public function show(Order $order)
    {
        // Otorisasi: pastikan pesanan ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('orders.show', compact('order'));
    }
}
