<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('seller')->check()) {
            $seller = Auth::guard('seller')->user();
            
            // Jika seller belum aktif sama sekali (is_active = false)
            if (!$seller->is_active && !$request->routeIs('seller.activation.*')) {
                return redirect()->route('seller.activation.index')
                    ->with('warning', 'Silakan aktivasi akun Anda terlebih dahulu.');
            }

            // Untuk route yang membutuhkan payment capability, check full activation
            $paymentRequiredRoutes = [
                'seller.orders.*',
                'seller.financial.*',
                'seller.payment.*'
            ];

            foreach ($paymentRequiredRoutes as $pattern) {
                if ($request->routeIs($pattern) && !$seller->canReceivePayments()) {
                    return redirect()->route('seller.activation.index')
                        ->with('warning', 'Silakan lengkapi konfigurasi Midtrans untuk mengakses fitur pembayaran.');
                }
            }
        }

        return $next($request);
    }
}