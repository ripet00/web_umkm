<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan yang masuk untuk seller.
     */
    public function index()
    {
        $sellerId = Auth::guard('seller')->id();
        
        // Ambil semua pesanan untuk seller ini, utamakan yang perlu diproses
        // Hanya tampilkan pesanan yang sudah dibayar (paid)
        $orders = Order::where('seller_id', $sellerId)
                        ->where('payment_status', 'paid') 
                        ->with('user', 'items.product')
                        ->latest()
                        ->paginate(10);
                        
        return view('seller.orders.index', compact('orders'));
    }
}

