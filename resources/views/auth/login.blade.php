<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4 py-6">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center space-x-2 text-2xl font-semibold text-gray-800 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>UMKM Marketplace</span>
                </a>
            </div>

            <!-- Judul -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">
                    Masuk Sebagai
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Pilih peran Anda untuk melanjutkan
                </p>
            </div>

            <!-- Pilihan Card -->
            <div class="space-y-4">
                
                <!-- User Card -->
                <a href="{{ route('user.login') }}" class="block group">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700
                                transition-all duration-200 group-hover:shadow-md group-hover:border-gray-300 dark:group-hover:border-gray-600">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-gray-600 transition-colors">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pengguna</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    Akses sebagai pembeli produk UMKM
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Seller Card -->
                <a href="{{ route('seller.login') }}" class="block group">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700
                                transition-all duration-200 group-hover:shadow-md group-hover:border-gray-300 dark:group-hover:border-gray-600">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-gray-600 transition-colors">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Penjual</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    Kelola toko dan produk UMKM
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Footer -->
            <div class="text-center mt-4 pt-3 border-t border-gray-200 dark:border-gray-800">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Butuh bantuan? <a href="#" class="text-gray-600 dark:text-gray-300 hover:underline">Hubungi kami</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>