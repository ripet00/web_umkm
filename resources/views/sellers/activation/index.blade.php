<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Aktivasi Akun Seller') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Notifications -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Peringatan!</strong>
                    <span class="block sm:inline">{{ session('warning') }}</span>
                </div>
            @endif

            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 md:p-8">
                    @php
                        $activationStatus = $seller->getActivationStatus();
                    @endphp
                    
                    <div class="flex items-center mb-4">
                        @if($activationStatus['can_receive_payments'])
                            <div class="flex items-center text-green-600">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg font-semibold">✅ Akun Fully Activated</span>
                            </div>
                        @elseif($activationStatus['can_manage_products'])
                            <div class="flex items-center text-yellow-600">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg font-semibold">🟡 Partial Activation - Dapat Kelola Produk</span>
                            </div>
                        @else
                            <div class="flex items-center text-red-600">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg font-semibold">❌ Akun Belum Aktif</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Nama Koperasi</p>
                            <p class="font-medium">{{ $seller->nama_koperasi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                            <p class="font-medium">{{ $seller->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Merchant ID</p>
                            <p class="font-medium">{{ $seller->merchant_id ?? 'Belum diisi' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Status Aktivasi</p>
                            @if($activationStatus['can_receive_payments'])
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ Fully Active - Dapat Terima Pembayaran
                                </span>
                            @elseif($activationStatus['can_manage_products'])
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    🟡 Partial Active - Dapat Kelola Produk
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    ❌ Tidak Aktif
                                </span>
                            @endif
                        </div>
                        
                        <!-- Progress bar dengan detil yang hilang -->
                        <div class="md:col-span-3">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Progress Aktivasi</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full" 
                                     style="width: {{ $activationStatus['progress_percentage'] }}%"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mt-2 text-xs">
                                <div class="flex items-center">
                                    @if($activationStatus['has_merchant_id'])
                                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    Merchant ID
                                </div>
                                <div class="flex items-center">
                                    @if($activationStatus['has_client_key'])
                                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    Client Key
                                </div>
                                <div class="flex items-center">
                                    @if($activationStatus['has_server_key'])
                                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    Server Key
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$activationStatus['can_receive_payments'])
                <!-- Informasi Panduan -->
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-6 mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                Cara Mendapatkan Merchant ID Midtrans
                            </h3>
                            <div class="text-blue-700 dark:text-blue-300 space-y-2">
                                <p>Untuk dapat menjual produk, Anda perlu mengaktifkan akun dengan Merchant ID dari Midtrans:</p>
                                <ol class="list-decimal list-inside space-y-1 ml-4">
                                    <li>Daftar akun di <a href="https://midtrans.com/" target="_blank" class="underline font-medium hover:text-blue-600">Midtrans.com</a></li>
                                    <li>Lengkapi verifikasi dokumen bisnis Anda</li>
                                    <li>Tunggu persetujuan dari tim Midtrans (1-3 hari kerja)</li>
                                    <li>Setelah disetujui, Anda akan mendapat Merchant ID</li>
                                    <li>Masukkan Merchant ID tersebut di form di bawah ini</li>
                                </ol>
                                <p class="font-medium">⚠️ Merchant ID diperlukan untuk memproses pembayaran dari pelanggan Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Aktivasi -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Aktivasi Akun Seller
                        </h3>
                        
                        <form action="{{ route('seller.activation.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <x-input-label for="merchant_id" value="Merchant ID Midtrans" />
                                <x-text-input 
                                    id="merchant_id" 
                                    name="merchant_id" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    :value="old('merchant_id', $seller->merchant_id)"
                                    placeholder="Contoh: G123456789"
                                    required 
                                />
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Masukkan Merchant ID yang Anda dapatkan dari Midtrans setelah akun disetujui.
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('merchant_id')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button type="submit">
                                    {{ __('Aktivasi Akun') }}
                                </x-primary-button>
                                
                                <a href="https://midtrans.com/" target="_blank" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path>
                                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
                                    </svg>
                                    Daftar Midtrans
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <!-- Akun Sudah Aktif -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                🎉 Selamat! Akun Anda Sudah Fully Active
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                Anda sekarang dapat mengelola produk dan menerima pembayaran melalui platform kami dengan integrasi blockchain EQBR.
                            </p>
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('seller.products.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    📦 Kelola Produk
                                </a>
                                <a href="{{ route('seller.orders.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    📋 Lihat Pesanan
                                </a>
                            </div>
                        </div>
                        
                        <!-- Form Deaktivasi (opsional) -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                ⚙️ Pengaturan Lanjutan
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Jika Anda ingin sementara menonaktifkan akun seller, klik tombol di bawah ini.
                            </p>
                            <form action="{{ route('seller.activation.deactivate') }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menonaktifkan akun seller? Anda tidak akan bisa menerima pesanan baru.')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    ❌ Nonaktifkan Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>