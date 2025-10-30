<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use App\Models\Seller;
use App\Models\Product;
use Illuminate\View\View;

class SellerProfileController extends Controller
{
    /**
     * Tampilkan profil seller untuk user (public view)
     */
    public function show(Seller $seller): View
    {
        // Ambil produk-produk seller dengan pagination
        $products = Product::where('seller_id', $seller->id)
            ->with(['images', 'category'])
            ->paginate(12);

        // Hitung statistik seller
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        
        return view('seller-profile.show', compact('seller', 'products', 'totalProducts'));
    }
    public function edit(Request $request)
    {
        return view('seller.profile.edit', [
            'seller' => $request->user('seller'),
        ]);
    }

    public function update(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sellers,email,' . $seller->id,
            'kecamatan' => 'required|string|max:255',
            'desa_kelurahan' => 'required|string|max:255',
            'jenis_usaha' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat_toko' => 'nullable|string',
            'deskripsi_toko' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->except(['foto_profil', '_token', '_method']);

        if ($request->hasFile('foto_profil')) {
            if ($seller->foto_profil) {
                Storage::disk('public')->delete($seller->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        $seller->update($data);

        return redirect()->route('seller.profile.edit')->with('status', 'profile-updated');
    }
}
