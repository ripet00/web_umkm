<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Aktivasi Akun Seller
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
                    <div class="flex items-center mb-4">
                        @if($seller->isActivated())
                            <div class="flex items-center text-green-600">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg font-semibold">Akun Aktif</span>
                            </div>
                        @else
                            <div class="flex items-center text-red-600">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg font-semibold">Akun Belum Aktif</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                            <p class="text-sm text-gray-600 dark:text-gray-400">Client Key</p>
                            <p class="font-medium">{{ $seller->client_key ? substr($seller->client_key, 0, 15) . '***' : 'Belum diisi' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Server Key</p>
                            <p class="font-medium">{{ $seller->server_key ? substr($seller->server_key, 0, 15) . '***' : 'Belum diisi' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $seller->isActivated() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $seller->isActivated() ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$seller->isActivated())
                <!-- Informasi Panduan -->
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-6 mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                Cara Mendapatkan Konfigurasi Midtrans
                            </h3>
                            <div class="text-blue-700 dark:text-blue-300 space-y-2">
                                <p>Untuk dapat menjual produk dan menerima pembayaran, Anda perlu mengisi 3 konfigurasi dari akun Midtrans:</p>
                                <ol class="list-decimal list-inside space-y-1 ml-4">
                                    <li>Daftar akun di <a href="https://midtrans.com/" target="_blank" class="underline font-medium hover:text-blue-600">Midtrans.com</a></li>
                                    <li>Lengkapi verifikasi dokumen bisnis Anda</li>
                                    <li>Tunggu persetujuan dari tim Midtrans (1-3 hari kerja)</li>
                                    <li>Setelah disetujui, masuk ke <strong>Settings > Configuration</strong> di dashboard Midtrans</li>
                                    <li>Salin <strong>Merchant ID</strong>, <strong>Client Key</strong>, dan <strong>Server Key</strong></li>
                                    <li>Masukkan ketiga informasi tersebut di form di bawah ini</li>
                                </ol>
                                <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded p-3 mt-3">
                                    <p class="font-medium text-yellow-800 dark:text-yellow-200">⚠️ Penting!</p>
                                    <p class="text-yellow-700 dark:text-yellow-300 text-sm">Ketiga konfigurasi ini <strong>WAJIB</strong> diisi sebelum Anda dapat:</p>
                                    <ul class="list-disc list-inside mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                                        <li>Menambahkan produk untuk dijual</li>
                                        <li>Menerima pembayaran dari customer</li>
                                        <li>Mengakses fitur penjualan lainnya</li>
                                    </ul>
                                </div>
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
                        
                        <form action="{{ route('seller.activation.update') }}" method="POST" class="space-y-6" style="display: block !important;">
                            @csrf
                            @method('PUT')
                            
                            <!-- Merchant ID Field -->
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <x-input-label for="merchant_id" value="Merchant ID Midtrans" />
                                <x-text-input 
                                    id="merchant_id" 
                                    name="merchant_id" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    :value="old('merchant_id', $seller->merchant_id)"
                                    placeholder="Contoh: G123456789"
                                    required 
                                    style="display: block !important; width: 100% !important; min-height: 42px !important;"
                                />
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Masukkan Merchant ID yang Anda dapatkan dari Midtrans setelah akun disetujui.
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('merchant_id')" />
                            </div>

                            <!-- Client Key Field -->
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <x-input-label for="client_key" value="Client Key Midtrans" />
                                <x-text-input 
                                    id="client_key" 
                                    name="client_key" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    :value="old('client_key', $seller->client_key)"
                                    placeholder="Contoh: Mid-client-..."
                                    required 
                                    style="display: block !important; width: 100% !important; min-height: 42px !important;"
                                />
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Client Key untuk integrasi pembayaran dari dashboard Midtrans Anda.
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('client_key')" />
                            </div>

                            <!-- Server Key Field -->
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <x-input-label for="server_key" value="Server Key Midtrans" />
                                <x-text-input 
                                    id="server_key" 
                                    name="server_key" 
                                    type="password" 
                                    class="mt-1 block w-full" 
                                    :value="old('server_key', $seller->server_key)"
                                    placeholder="Contoh: Mid-server-..."
                                    required 
                                    style="display: block !important; width: 100% !important; min-height: 42px !important;"
                                />
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Server Key rahasia untuk komunikasi server-to-server dengan Midtrans.
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('server_key')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button type="submit">
                                    Aktivasi Akun
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

                <!-- Download Panduan Section -->
                <div class="mt-6 bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 rounded-lg p-6 border border-green-200 dark:border-green-700">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-2 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                📚 Panduan Lengkap
                            </h4>
                            <p class="text-sm text-green-800 dark:text-green-200 mb-3">
                                Download panduan aktivasi dan verifikasi blockchain untuk memahami proses secara detail
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                    Aktivasi Seller
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    Blockchain Verification
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                    Payment Gateway
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ asset('downloads/panduan_aktivasi.pdf') }}" 
                                download="Panduan_Aktivasi_Blockchain_UMKM.pdf"
                                class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg
                                          transition duration-200 ease-in-out transform hover:scale-105
                                          focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2
                                          shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Panduan
                            </a>
                            <a href="{{ route('blockchain.verify') }}" 
                                target="_blank"
                                class="inline-flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg
                                          transition duration-200 ease-in-out transform hover:scale-105
                                          focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2
                                          shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Verifikasi Blockchain
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Akun Sudah Aktif -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                Selamat! Akun Anda Sudah Aktif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                Anda sekarang dapat menjual produk dan menerima pembayaran melalui platform kami.
                            </p>
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('seller.products.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Kelola Produk
                                </a>
                                <a href="{{ route('seller.orders.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Lihat Pesanan
                                </a>
                            </div>
                        </div>
                        
                        <!-- Form Deaktivasi (opsional) -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                Pengaturan Lanjutan
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
                                    Nonaktifkan Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>