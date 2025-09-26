<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama dengan semua produk.
     */
    public function index(Request $request)
    {
        $query = Product::with('category', 'seller');
        
        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Filter Kategori
        if ($request->filled('category')) {
            // Memperbaiki kesalahan ketik dari whereHase menjadi whereHas
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Ambil semua produk untuk ditampilkan di landing page
        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        // Memperbaiki agar $categories dikirim ke view
        return view('landing', compact('products', 'categories'));
    }

    /**
     * Menampilkan detail satu produk.
     */
    public function show(Product $product)
    {
        // Load relasi seller dan category
        $product->load('seller', 'category');
        return view('products.show', compact('product'));
    }
}

