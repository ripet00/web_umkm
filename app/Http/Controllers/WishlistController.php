<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Display wishlist page
     */
    public function index()
    {
        $user = Auth::user();
        
        $wishlistProducts = $user->wishlistProducts()
            ->with(['category', 'primaryImage', 'seller'])
            ->paginate(12);

        return view('wishlist.index', compact('wishlistProducts'));
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sudah ada di wishlist'
            ], 409);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke wishlist'
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function destroy($productId)
    {
        $user = Auth::user();

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if (!$wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di wishlist'
            ], 404);
        }

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari wishlist'
        ]);
    }

    /**
     * Toggle wishlist (add if not exists, remove if exists)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            // Remove from wishlist
            $wishlist->delete();
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Produk dihapus dari wishlist'
            ]);
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Produk ditambahkan ke wishlist'
            ]);
        }
    }
}