<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\EQBRBlockchainService;

class BlockchainController extends Controller
{
    protected $blockchainService;

    public function __construct(EQBRBlockchainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    /**
     * Show blockchain verification page
     */
    public function verify()
    {
        return view('blockchain.verify');
    }

    /**
     * Verify blockchain hash
     */
    public function check(Request $request)
    {
        $request->validate([
            'hash' => 'required|string'
        ]);

        $hash = $request->input('hash');
        
        // Check if hash exists in our database
        $order = Order::where('blockchain_hash', $hash)->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Hash blockchain tidak ditemukan dalam sistem kami'
            ]);
        }

        // Verify with EQBR blockchain
        $verification = $this->blockchainService->verifyHash($hash);
        
        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => $order->total_harga,
                'created_at' => $order->created_at->format('d M Y, H:i'),
                'payment_status' => $order->payment_status,
                'blockchain_status' => $order->blockchain_status,
                'blockchain_hash' => $order->blockchain_hash,
                'blockchain_transaction_id' => $order->blockchain_transaction_id,
                'block_number' => $order->block_number
            ],
            'blockchain_verification' => $verification
        ]);
    }

    /**
     * Get blockchain transaction details
     */
    public function transaction($hash)
    {
        $order = Order::where('blockchain_hash', $hash)->first();
        
        if (!$order) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $verification = $this->blockchainService->verifyHash($hash);
        
        return view('blockchain.transaction', compact('order', 'verification'));
    }
}