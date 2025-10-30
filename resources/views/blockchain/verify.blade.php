<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verifikasi Blockchain') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <div class="text-center mb-8">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                            🔗 Verifikasi Transaksi Blockchain
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                            Masukkan hash blockchain untuk memverifikasi keaslian dan integritas transaksi Anda. 
                            Semua transaksi dicatat dalam blockchain EQBR untuk transparansi penuh.
                        </p>
                    </div>

                    <div class="max-w-xl mx-auto">
                        <form id="verifyForm" class="space-y-4">
                            @csrf
                            <div>
                                <label for="hash" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Hash Blockchain
                                </label>
                                <input type="text" 
                                       id="hash" 
                                       name="hash" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                              bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                              focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                              font-mono text-sm"
                                       placeholder="Masukkan hash blockchain..."
                                       required>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg
                                           transition duration-200 ease-in-out transform hover:scale-105
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Verifikasi Transaksi
                                </span>
                            </button>
                        </form>

                        <!-- Loading State -->
                        <div id="loading" class="hidden text-center py-8">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                            <p class="mt-4 text-gray-600 dark:text-gray-400">Memverifikasi transaksi...</p>
                        </div>

                        <!-- Results -->
                        <div id="results" class="hidden mt-8"></div>
                    </div>

                    <!-- Information Section -->
                    <div class="mt-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">
                            ℹ️ Tentang Verifikasi Blockchain
                        </h4>
                        <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                            <p>• Setiap transaksi yang berhasil dibayar akan dicatat dalam blockchain EQBR</p>
                            <p>• Hash blockchain memberikan bukti keaslian dan integritas transaksi</p>
                            <p>• Data yang tersimpan tidak dapat diubah atau dipalsukan</p>
                            <p>• Verifikasi dapat dilakukan kapan saja oleh siapa pun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('verifyForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const hash = document.getElementById('hash').value.trim();
            const loading = document.getElementById('loading');
            const results = document.getElementById('results');
            const form = document.getElementById('verifyForm');
            
            if (!hash) {
                alert('Mohon masukkan hash blockchain');
                return;
            }
            
            // Show loading
            form.style.display = 'none';
            loading.classList.remove('hidden');
            results.classList.add('hidden');
            
            try {
                const response = await fetch('/blockchain/check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ hash: hash })
                });
                
                const data = await response.json();
                
                // Hide loading
                loading.classList.add('hidden');
                form.style.display = 'block';
                
                if (data.success) {
                    displaySuccess(data.order, data.blockchain_verification);
                } else {
                    displayError(data.message);
                }
                
            } catch (error) {
                loading.classList.add('hidden');
                form.style.display = 'block';
                displayError('Terjadi kesalahan saat memverifikasi hash');
                console.error('Error:', error);
            }
        });
        
        function displaySuccess(order, verification) {
            const results = document.getElementById('results');
            results.innerHTML = `
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-3">
                                ✅ Transaksi Terverifikasi
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="font-medium text-green-700 dark:text-green-300">ID Pesanan:</p>
                                    <p class="text-green-600 dark:text-green-400">#${order.id}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-green-700 dark:text-green-300">Total Pembayaran:</p>
                                    <p class="text-green-600 dark:text-green-400">Rp ${new Intl.NumberFormat('id-ID').format(order.total_amount)}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-green-700 dark:text-green-300">Tanggal Transaksi:</p>
                                    <p class="text-green-600 dark:text-green-400">${order.created_at}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-green-700 dark:text-green-300">Status Blockchain:</p>
                                    <p class="text-green-600 dark:text-green-400">${order.blockchain_status || 'confirmed'}</p>
                                </div>
                            </div>
                            ${order.blockchain_transaction_id ? `
                                <div class="mt-4 p-3 bg-white dark:bg-gray-800 rounded border">
                                    <p class="font-medium text-green-700 dark:text-green-300 mb-1">Transaction ID Blockchain:</p>
                                    <p class="text-xs font-mono text-green-600 dark:text-green-400 break-all">${order.blockchain_transaction_id}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
            results.classList.remove('hidden');
        }
        
        function displayError(message) {
            const results = document.getElementById('results');
            results.innerHTML = `
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">
                                ❌ Verifikasi Gagal
                            </h4>
                            <p class="text-red-600 dark:text-red-400">${message}</p>
                        </div>
                    </div>
                </div>
            `;
            results.classList.remove('hidden');
        }
    </script>
    @endpush
</x-app-layout>