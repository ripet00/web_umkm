<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama dengan semua produk.
     */
    public function index()
    {
        // Ambil semua produk untuk ditampilkan di landing page
        $products = Product::latest()->paginate(12);
        return view('landing', compact('products'));
    }

    /**
     * Menampilkan detail satu produk.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product')); // Anda perlu membuat view ini
    }
}
