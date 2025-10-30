<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class PublicTransactionController extends Controller
{
    /**
     * Show public transaction transparency page
     */
    public function index(Request $request)
    {
        $query = Order::where('payment_status', 'paid')
                     ->whereNotNull('blockchain_hash')
                     ->with(['user:id,nama', 'orderItems.product:id,nama_produk'])
                     ->latest();

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by seller
        if ($request->filled('seller_id')) {
            $query->whereHas('orderItems.product', function($q) use ($request) {
                $q->where('seller_id', $request->seller_id);
            });
        }

        $transactions = $query->paginate(20);
        
        // Statistics
        $stats = [
            'total_transactions' => Order::where('payment_status', 'paid')->whereNotNull('blockchain_hash')->count(),
            'total_amount' => Order::where('payment_status', 'paid')->whereNotNull('blockchain_hash')->sum('total_price'),
            'today_transactions' => Order::where('payment_status', 'paid')->whereNotNull('blockchain_hash')->whereDate('created_at', today())->count(),
        ];

        return view('public.transactions.index', compact('transactions', 'stats'));
    }

    /**
     * Show specific transaction details
     */
    public function show($hash)
    {
        $transaction = Order::where('blockchain_hash', $hash)
                           ->with(['user:id,nama', 'orderItems.product:id,nama_produk,seller_id'])
                           ->firstOrFail();

        return view('public.transactions.show', compact('transaction'));
    }

    /**
     * API endpoint for transparency data
     */
    public function api(Request $request)
    {
        $transactions = Order::where('payment_status', 'paid')
                            ->whereNotNull('blockchain_hash')
                            ->select([
                                'id',
                                'blockchain_hash',
                                'blockchain_transaction_id',
                                'block_number',
                                'total_price',
                                'created_at',
                                'blockchain_status'
                            ])
                            ->latest()
                            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $transactions,
            'transparency_note' => 'All transactions are recorded on EQBR blockchain for full transparency'
        ]);
    }
}