<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Informasi Toko') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Perbarui informasi profil dan alamat email toko Anda.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('seller.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="nama_koperasi" value="Nama Koperasi/UMKM" />
                                <x-text-input id="nama_koperasi" name="nama_koperasi" type="text" class="mt-1 block w-full" :value="old('nama_koperasi', $seller->nama_koperasi)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_koperasi')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $seller->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="no_hp" value="Nomor HP" />
                                <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $seller->no_hp)" />
                                <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
                            </div>

                            <div>
                                <x-input-label for="jenis_usaha" value="Jenis Usaha" />
                                <x-text-input id="jenis_usaha" name="jenis_usaha" type="text" class="mt-1 block w-full" :value="old('jenis_usaha', $seller->jenis_usaha)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_usaha')" />
                            </div>
                            
                            <div>
                                <x-input-label for="kecamatan" value="Kecamatan" />
                                <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" :value="old('kecamatan', $seller->kecamatan)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('kecamatan')" />
                            </div>

                            <div>
                                <x-input-label for="desa_kelurahan" value="Desa/Kelurahan" />
                                <x-text-input id="desa_kelurahan" name="desa_kelurahan" type="text" class="mt-1 block w-full" :value="old('desa_kelurahan', $seller->desa_kelurahan)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('desa_kelurahan')" />
                            </div>

                            <div>
                                <x-input-label for="alamat_toko" value="Alamat Toko" />
                                <textarea id="alamat_toko" name="alamat_toko" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('alamat_toko', $seller->alamat_toko) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('alamat_toko')" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi_toko" value="Deskripsi Toko" />
                                <textarea id="deskripsi_toko" name="deskripsi_toko" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi_toko', $seller->deskripsi_toko) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_toko')" />
                            </div>

                             <div>
                                <x-input-label for="foto_profil" value="Foto Profil" />
                                <input id="foto_profil" name="foto_profil" type="file" class="mt-1 block w-full text-gray-500">
                                <x-input-error class="mt-2" :messages="$errors->get('foto_profil')" />
                                @if ($seller->foto_profil)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Foto saat ini:</p>
                                        <img src="{{ asset('storage/' . $seller->foto_profil) }}" alt="Foto Profil" class="mt-2 h-20 w-20 object-cover rounded-full">
                                    </div>
                                @endif
                            </div>


                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Tersimpan.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
