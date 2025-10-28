@extends('layouts.seller')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Aktivasi Merchant (Midtrans)</h2>

                    @if(session('success'))
                        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
                    @endif

                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">Masukkan Merchant ID (MID) yang Anda dapatkan dari Midtrans. Jika belum memiliki MID, ikuti langkah aktivasi di bawah ini.</p>

                    <form action="{{ route('seller.activation.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="merchant_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Merchant ID (MID)</label>
                            <input id="merchant_id" name="merchant_id" type="text" value="{{ old('merchant_id', $seller->merchant_id) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required>
                            @error('merchant_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Simpan & Aktivasi</button>
                            <form method="POST" action="{{ route('seller.activation.deactivate') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700">Nonaktifkan</button>
                            </form>
                        </div>
                    </form>

                    <hr class="my-6">

                    <h3 class="text-lg font-semibold mb-2">Cara mendapatkan Merchant ID (MID) di Midtrans</h3>
                    <ol class="list-decimal list-inside text-sm text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Daftar/masuk ke akun Midtrans di <a class="text-indigo-600" href="https://midtrans.com/" target="_blank" rel="noreferrer">https://midtrans.com/</a></li>
                        <li>Lengkapi profil bisnis dan dokumen yang diminta (KTP, NPWP, rekening bank, dsb.)</li>
                        <li>Ajukan permohonan aktivasi merchant pada dashboard Midtrans dan tunggu verifikasi</li>
                        <li>Setelah diverifikasi, Anda akan menerima Merchant ID (MID) di dashboard Midtrans</li>
                        <li>Salin MID dan tempelkan di form aktivasi di halaman ini</li>
                    </ol>

                    <p class="mt-4 text-sm text-gray-500">Catatan: MID disimpan pada akun seller Anda dan akan digunakan untuk mengarahkan pembayaran ke akun merchant Anda.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
