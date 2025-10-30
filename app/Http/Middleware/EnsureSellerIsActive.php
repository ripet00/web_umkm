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
            
            // Jika seller belum aktif dan bukan mengakses halaman aktivasi
            if (!$seller->isActivated() && !$request->routeIs('seller.activation.*')) {
                return redirect()->route('seller.activation.index')
                    ->with('warning', 'Silakan aktivasi akun Anda terlebih dahulu dengan mengisi Merchant ID.');
            }
        }

        return $next($request);
    }
}