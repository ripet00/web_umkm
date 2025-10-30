<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🔍 {{ __('Transparansi Transaksi Blockchain') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transaksi Blockchain</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ number_format($stats['total_transactions']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Volume</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                Rp {{ number_format($stats['total_amount']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Hari Ini</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ number_format($stats['today_transactions']) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">🔍 Filter Transaksi</h3>
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Range Amount</label>
                            <select name="amount_range" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                <option value="">Semua Amount</option>
                                <option value="0-100000">< Rp 100.000</option>
                                <option value="100000-500000">Rp 100.000 - 500.000</option>
                                <option value="500000-1000000">Rp 500.000 - 1.000.000</option>
                                <option value="1000000+"> > Rp 1.000.000</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Transactions Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">📋 Log Transaksi Publik</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('public.transactions.api') }}" target="_blank" 
                               class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                                📊 API Data
                            </a>
                            <a href="{{ route('blockchain.verify') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                🔍 Verifikasi Hash
                            </a>
                        </div>
                    </div>

                    @if($transactions->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada transaksi blockchain</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Transaksi yang berhasil dibayar akan muncul di sini</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hash Blockchain</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount Range</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Items</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($transactions as $transaction)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $transaction->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="font-mono bg-gray-100 dark:bg-gray-700 p-2 rounded text-xs break-all max-w-xs">
                                                {{ Str::limit($transaction->blockchain_hash, 20) }}...
                                                <button onclick="copyToClipboard('{{ $transaction->blockchain_hash }}')" 
                                                        class="ml-2 text-blue-600 hover:text-blue-800">
                                                    📋
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            @php
                                                $amount = $transaction->total_price;
                                                if ($amount < 100000) echo "< Rp 100K";
                                                elseif ($amount < 500000) echo "Rp 100K - 500K";
                                                elseif ($amount < 1000000) echo "Rp 500K - 1M";
                                                else echo "> Rp 1M";
                                            @endphp
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $transaction->orderItems->count() }} produk
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                @if($transaction->blockchain_status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                @elseif($transaction->blockchain_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                                                🔗 {{ ucfirst($transaction->blockchain_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('public.transactions.show', $transaction->blockchain_hash) }}" 
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3">
                                                👁️ Detail
                                            </a>
                                            <a href="{{ route('blockchain.verify') }}?hash={{ $transaction->blockchain_hash }}" 
                                               class="text-green-600 hover:text-green-900 dark:text-green-400">
                                                ✅ Verify
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info Section --}}
            <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">
                    ℹ️ Tentang Transparansi Blockchain
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800 dark:text-blue-200">
                    <div>
                        <h5 class="font-semibold mb-2">🔍 Yang Dipublikasikan:</h5>
                        <ul class="space-y-1">
                            <li>• Hash blockchain transaksi</li>
                            <li>• Timestamp transaksi</li>
                            <li>• Status blockchain</li>
                            <li>• Range amount (privacy-friendly)</li>
                            <li>• Jumlah item</li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-semibold mb-2">🔒 Yang Dilindungi:</h5>
                        <ul class="space-y-1">
                            <li>• Data personal pembeli</li>
                            <li>• Detail alamat pengiriman</li>
                            <li>• Informasi kontak</li>
                            <li>• Jumlah pembayaran exact</li>
                            <li>• Detail produk spesifik</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show toast or feedback
                alert('Hash copied to clipboard!');
            });
        }
    </script>
    @endpush
</x-app-layout>