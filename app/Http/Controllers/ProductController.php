<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; // <-- 1. Tambahkan use statement untuk Category
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil produk HANYA milik seller yang sedang login.
        $products = Auth::guard('seller')->user()->products()->with('category')->latest()->paginate(10);
        return view('sellers.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // <-- 2. Ambil semua data kategori
        $categories = Category::all(); 
        // <-- 3. Kirim data kategori ke view
        return view('sellers.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $seller = Auth::guard('seller')->user();

        $path = null;
        if ($request->hasFile('gambar_produk')) {
            $path = $request->file('gambar_produk')->store('products', 'public');
        }

        $seller->products()->create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'gambar_produk' => $path,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (auth('seller')->id() !== $product->seller_id) {
            abort(403);
        }
        return view('sellers.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (auth('seller')->id() !== $product->seller_id) {
            abort(403);
        }

        $categories = Category::all();
        return view('sellers.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if (auth('seller')->id() !== $product->seller_id) {
            abort(403);
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('gambar_produk');

        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama jika ada
            if ($product->gambar_produk) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->gambar_produk);
            }
            $data['gambar_produk'] = $request->file('gambar_produk')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (auth('seller')->id() !== $product->seller_id) {
            abort(403);
        }

        if ($product->gambar_produk) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->gambar_produk);
        }
        
        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}

