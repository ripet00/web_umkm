<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4 py-6">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center space-x-2 text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>UMKM Marketplace</span>
                </a>
                
                <div class="w-14 h-14 mx-auto mb-3 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-1">Daftar sebagai Pengguna</h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Buat akun baru untuk mulai berbelanja</p>
            </div>

            <!-- Register Form -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="nama" value="Nama Lengkap" class="mb-1 text-sm" />
                        <x-text-input 
                            id="nama" 
                            class="block w-full text-sm" 
                            type="text" 
                            name="nama" 
                            :value="old('nama')" 
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap" />
                        <x-input-error :messages="$errors->get('nama')" class="mt-1 text-xs" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Alamat Email')" class="mb-1 text-sm" />
                        <x-text-input 
                            id="email" 
                            class="block w-full text-sm" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autocomplete="email"
                            placeholder="nama@contoh.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    <!-- Alamat -->
                    <div class="mb-4">
                        <x-input-label for="alamat" value="Alamat" class="mb-1 text-sm" />
                        <x-text-input 
                            id="alamat" 
                            class="block w-full text-sm" 
                            type="text" 
                            name="alamat" 
                            :value="old('alamat')" 
                            required 
                            placeholder="Masukkan alamat lengkap" />
                        <x-input-error :messages="$errors->get('alamat')" class="mt-1 text-xs" />
                    </div>

                    <!-- No HP -->
                    <div class="mb-4">
                        <x-input-label for="no_hp" value="No. Handphone" class="mb-1 text-sm" />
                        <x-text-input 
                            id="no_hp" 
                            class="block w-full text-sm" 
                            type="text" 
                            name="no_hp" 
                            :value="old('no_hp')" 
                            required 
                            placeholder="Contoh: 081234567890" />
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-1 text-xs" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Kata Sandi')" class="mb-1 text-sm" />
                        <x-text-input 
                            id="password" 
                            class="block w-full text-sm"
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="mb-1 text-sm" />
                        <x-text-input 
                            id="password_confirmation" 
                            class="block w-full text-sm"
                            type="password"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Ketik ulang kata sandi" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                    </div>

                    <!-- Register Button -->
                    <button type="submit" 
                            class="w-full bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 
                                   text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 
                                   focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-sm">
                        Daftar
                    </button>

                    <!-- Login Link -->
                    <div class="text-center mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Sudah punya akun? 
                            <a href="{{ route('user.login') }}" 
                               class="text-gray-800 dark:text-gray-200 font-medium hover:underline">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Back Link -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" 
                   class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke pemilihan peran
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>