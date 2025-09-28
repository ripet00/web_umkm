<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        return view('cart.index', compact('cart'));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = Auth::user();

        // Cari atau buat keranjang untuk user
        $cart = $user->cart()->firstOrCreate([]);

        // Cek apakah item sudah ada di keranjang
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan quantity-nya
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stok < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $cartItem->increment('quantity', $request->quantity);
        } else {
            // Jika belum ada, buat item baru
            if ($product->stok < $request->quantity) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Mengupdate jumlah item di keranjang.
     */
    public function update(Request $request, CartItem $item)
    {
        // Pastikan item ini milik user yang sedang login
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        
        if ($item->product->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $item->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function destroy(CartItem $item)
    {
        // Pastikan item ini milik user yang sedang login
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();
        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}

