<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Wishlist;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Statistics
        $totalOrders = $user->orders()->count();
        
        $activeOrders = $user->orders()
            ->whereIn('status', ['pending', 'processing', 'shipped'])
            ->count();
        
        // Total spending - hanya order yang completed dan paid
        $totalSpending = $user->orders()
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->sum('total_price');
        
        $wishlistCount = $user->wishlists()->count();

        // Recent Orders dengan relationship
        $recentOrders = $user->orders()
            ->with(['seller', 'orderItems.product.primaryImage'])
            ->latest()
            ->take(5)
            ->get();

        // Wishlist Products
        $wishlistProducts = $user->wishlistProducts()
            ->with(['category', 'primaryImage', 'seller'])
            ->latest('wishlists.created_at')
            ->take(5)
            ->get();

        // Recommended Products - products yang stok masih ada
        $recommendedProducts = Product::with(['category', 'primaryImage', 'seller'])
            ->where('stok', '>', 0)
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('dashboard', compact(
            'user',
            'totalOrders',
            'activeOrders',
            'totalSpending',
            'wishlistCount',
            'recentOrders',
            'wishlistProducts',
            'recommendedProducts'
        ));
    }
}