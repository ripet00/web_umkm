<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Jika yang login adalah seller, alihkan ke dashboard seller
                if ($guard === 'seller') {
                    return redirect()->route('seller.dashboard');
                }

                // Jika tidak, alihkan ke dashboard pengguna biasa (default)
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
