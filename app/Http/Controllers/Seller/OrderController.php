<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan pesanan yang masuk untuk produk milik seller.
     */
    public function index()
    {
        $sellerId = Auth::guard('seller')->id();

        $orders = Order::whereHas('items.product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })
        ->with(['items' => function($query) use ($sellerId) {
            $query->whereHas('product', function($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->with('product');
        }, 'user'])
        ->where('status', 'paid') // Hanya tampilkan yang sudah dibayar
        ->latest()
        ->paginate(10);
        
        return view('sellers.orders.index', compact('orders'));
    }
}
