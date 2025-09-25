<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SellerLoginController extends Controller
{
    /**
     * Menampilkan form login untuk seller.
     */
    public function create(): View
    {
        return view('auth.seller-login'); // Kita akan buat view ini
    }

    /**
     * Menangani permintaan login dari seller.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Coba otentikasi menggunakan guard 'seller'
        if (! Auth::guard('seller')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        // Arahkan ke dashboard seller setelah login berhasil
        return redirect()->intended(route('seller.dashboard'));
    }

    /**
     * Menangani permintaan logout dari seller.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('seller')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

