<x-guest-layout>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center mb-4">
        Daftar sebagai Penjual
    </h2>

    <form method="POST" action="{{ route('seller.register') }}">
        @csrf

        <!-- Nama Koperasi -->
        <div>
            <x-input-label for="nama_koperasi" value="Nama Koperasi/UMKM" />
            <x-text-input id="nama_koperasi" class="block mt-1 w-full" type="text" name="nama_koperasi" :value="old('nama_koperasi')" required autofocus />
            <x-input-error :messages="$errors->get('nama_koperasi')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Kecamatan -->
        <div class="mt-4">
            <x-input-label for="kecamatan" value="Kecamatan" />
            <x-text-input id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan" :value="old('kecamatan')" required />
            <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
        </div>

        <!-- Desa/Kelurahan -->
        <div class="mt-4">
            <x-input-label for="desa_kelurahan" value="Desa/Kelurahan" />
            <x-text-input id="desa_kelurahan" class="block mt-1 w-full" type="text" name="desa_kelurahan" :value="old('desa_kelurahan')" required />
            <x-input-error :messages="$errors->get('desa_kelurahan')" class="mt-2" />
        </div>

        <!-- Jenis Usaha -->
        <div class="mt-4">
            <x-input-label for="jenis_usaha" value="Jenis Usaha" />
            <x-text-input id="jenis_usaha" class="block mt-1 w-full" type="text" name="jenis_usaha" :value="old('jenis_usaha')" required />
            <x-input-error :messages="$errors->get('jenis_usaha')" class="mt-2" />
        </div>

        <!-- No. HP -->
        <div class="mt-4">
            <x-input-label for="no_hp" value="No. HP" />
            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp')" required />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('seller.login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button class="ms-4">
                Daftar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
