<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl overflow-hidden">
                
                <form method="post" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
                        
                        {{-- Left Section: Profile Photo --}}
                        <div class="lg:col-span-1 space-y-6">
                            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-800 p-6 rounded-2xl">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 text-center">
                                    Foto Profil Toko
                                </h3>
                                
                                <div class="flex flex-col items-center">
                                    {{-- Preview Foto --}}
                                    <div class="relative group">
                                        @if ($seller->foto_profil)
                                            <img id="preview-image" src="{{ asset('storage/' . $seller->foto_profil) }}" alt="Foto Profil" class="w-40 h-40 object-cover rounded-full border-4 border-white dark:border-gray-600 shadow-xl">
                                        @else
                                            <div id="preview-placeholder" class="w-40 h-40 rounded-full border-4 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <img id="preview-image" src="" alt="Preview" class="hidden w-40 h-40 object-cover rounded-full border-4 border-white dark:border-gray-600 shadow-xl">
                                        @endif
                                        
                                        {{-- Edit Icon Overlay --}}
                                        <label for="foto_profil" class="absolute bottom-2 right-2 bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-full cursor-pointer shadow-lg transition transform hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </label>
                                    </div>

                                    <input id="foto_profil" name="foto_profil" type="file" accept="image/*" class="hidden">
                                    
                                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                                        Klik ikon kamera untuk mengunggah foto
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 text-center mt-1">
                                        JPG, PNG atau GIF (Max. 2MB)
                                    </p>
                                    
                                    <x-input-error class="mt-2 text-center" :messages="$errors->get('foto_profil')" />
                                </div>
                            </div>

                            {{-- Info Card --}}
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-200 dark:border-blue-800">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-300">Tips Profil</h4>
                                        <p class="text-xs text-blue-700 dark:text-blue-400 mt-1">
                                            Lengkapi profil toko Anda untuk meningkatkan kepercayaan pembeli dan visibilitas toko di marketplace.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Section: Form Fields --}}
                        <div class="lg:col-span-2 space-y-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    Informasi Toko
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                    Perbarui informasi profil dan detail toko Anda
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Nama Koperasi/UMKM --}}
                                <div class="md:col-span-2">
                                    <label for="nama_koperasi" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Koperasi/UMKM <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <input id="nama_koperasi" name="nama_koperasi" type="text" 
                                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:focus:border-indigo-500 transition" 
                                               value="{{ old('nama_koperasi', $seller->nama_koperasi) }}" 
                                               placeholder="Masukkan nama koperasi/UMKM"
                                               required>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('nama_koperasi')" />
                                </div>

                                {{-- Email --}}
                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                            </svg>
                                        </div>
                                        <input id="email" name="email" type="email" 
                                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition" 
                                               value="{{ old('email', $seller->email) }}" 
                                               placeholder="email@example.com"
                                               required>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>

                                {{-- Nomor HP --}}
                                <div>
                                    <label for="no_hp" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nomor HP
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <input id="no_hp" name="no_hp" type="text" 
                                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition" 
                                               value="{{ old('no_hp', $seller->no_hp) }}" 
                                               placeholder="08123456789">
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
                                </div>

                                {{-- Jenis Usaha --}}
                                <div>
                                    <label for="jenis_usaha" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Jenis Usaha <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <input id="jenis_usaha" name="jenis_usaha" type="text" 
                                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition" 
                                               value="{{ old('jenis_usaha', $seller->jenis_usaha) }}" 
                                               placeholder="Contoh: Makanan, Fashion, Kerajinan"
                                               required>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('jenis_usaha')" />
                                </div>

                                {{-- Kecamatan --}}
                                <div>
                                    <label for="kecamatan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Kecamatan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <input id="kecamatan" name="kecamatan" type="text" 
                                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition" 
                                               value="{{ old('kecamatan', $seller->kecamatan) }}" 
                                               placeholder="Nama kecamatan"
                                               required>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('kecamatan')" />
                                </div>

                                {{-- Desa/Kelurahan --}}
                                <div>
                                    <label for="desa_kelurahan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Desa/Kelurahan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        </div>
                                        <input id="desa_kelurahan" name="desa_kelurahan" type="text" 
                                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition" 
                                               value="{{ old('desa_kelurahan', $seller->desa_kelurahan) }}" 
                                               placeholder="Nama desa/kelurahan"
                                               required>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('desa_kelurahan')" />
                                </div>

                                {{-- Alamat Toko --}}
                                <div class="md:col-span-2">
                                    <label for="alamat_toko" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Alamat Lengkap Toko
                                    </label>
                                    <textarea id="alamat_toko" name="alamat_toko" rows="3" 
                                              class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition resize-none" 
                                              placeholder="Masukkan alamat lengkap toko Anda">{{ old('alamat_toko', $seller->alamat_toko) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('alamat_toko')" />
                                </div>

                                {{-- Deskripsi Toko --}}
                                <div class="md:col-span-2">
                                    <label for="deskripsi_toko" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Deskripsi Toko
                                    </label>
                                    <textarea id="deskripsi_toko" name="deskripsi_toko" rows="4" 
                                              class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition resize-none" 
                                              placeholder="Ceritakan tentang toko Anda...">{{ old('deskripsi_toko', $seller->deskripsi_toko) }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Deskripsi yang baik akan menarik lebih banyak pembeli
                                    </p>
                                    <x-input-error class="mt-2" :messages="$errors->get('deskripsi_toko')" />
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-4">
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Simpan Perubahan
                                    </button>

                                    @if (session('status') === 'profile-updated')
                                        <div x-data="{ show: true }" 
                                             x-show="show" 
                                             x-transition
                                             x-init="setTimeout(() => show = false, 3000)"
                                             class="flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-lg">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-sm font-medium">Berhasil disimpan!</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script for Image Preview --}}
    <script>
        document.getElementById('foto_profil').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('preview-image');
                    const placeholder = document.getElementById('preview-placeholder');
                    
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-seller-layout>