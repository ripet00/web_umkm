<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ActivationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller');
    }

    /**
     * Tampilkan halaman aktivasi merchant
     */
  public function index(): View
  {
      $seller = Auth::guard('seller')->user();
      return view('sellers.activation', compact('seller'));
  }

  /**
     * Update merchant ID dan aktivasi seller
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'merchant_id' => 'required|string|max:255',
        ], [
            'merchant_id.required' => 'Merchant ID wajib diisi.',
        ]);

        $seller = Auth::guard('seller')->user();
        $seller->update([
            'merchant_id' => $request->merchant_id,
            'is_active' => true,
        ]);

        return redirect()->route('seller.activation.index')
            ->with('success', 'Merchant ID berhasil disimpan dan akun diaktifkan.');
    }

    /**
     * Nonaktifkan seller (opsional)
     */
    public function deactivate(): RedirectResponse
    {
        $seller = Auth::guard('seller')->user();
        $seller->update([
            'is_active' => false,
        ]);

        return redirect()->route('seller.activation.index')
            ->with('warning', 'Akun seller berhasil dinonaktifkan.');
    }
}