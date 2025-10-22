<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class SellerRegisterController extends Controller
{
    /**
     * Menampilkan form registrasi untuk seller.
     */
    public function create(): View
    {
        return view('auth.seller-register');
    }

    /**
     * Menangani permintaan registrasi dari seller.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_koperasi' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Seller::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kecamatan' => ['required', 'string', 'max:255'],
            'desa_kelurahan' => ['required', 'string', 'max:255'],
            'jenis_usaha' => ['required', 'string', 'max:255'],
        ]);

        $seller = Seller::create([
            'nama_koperasi' => $request->nama_koperasi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
            'jenis_usaha' => $request->jenis_usaha,
            'no_hp' => $request->no_hp,
        ]);

        event(new Registered($seller));

        Auth::guard('seller')->login($seller);

        return redirect()->route('seller.dashboard');
    }
}
