<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🔍 {{ __('Detail Transaksi Blockchain') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('public.transactions.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Transparansi
                </a>
            </div>

            {{-- Transaction Detail Card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            🔗 Transaksi #{{ $transaction->id }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Dicatat pada {{ $transaction->created_at->format('d F Y, H:i') }} WIB
                        </p>
                    </div>

                    {{-- Blockchain Information --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        {{-- Left Column: Blockchain Data --}}
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                🔐 Informasi Blockchain
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Hash Blockchain
                                    </label>
                                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg font-mono text-sm break-all">
                                        {{ $transaction->blockchain_hash }}
                                        <button onclick="copyToClipboard('{{ $transaction->blockchain_hash }}')" 
                                                class="ml-2 text-blue-600 hover:text-blue-800 float-right">
                                            📋 Copy
                                        </button>
                                    </div>
                                </div>

                                @if($transaction->blockchain_transaction_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Transaction ID
                                    </label>
                                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg font-mono text-sm break-all">
                                        {{ $transaction->blockchain_transaction_id }}
                                    </div>
                                </div>
                                @endif

                                @if($transaction->block_number)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Block Number
                                    </label>
                                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg font-mono text-sm">
                                        #{{ number_format($transaction->block_number) }}
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Status Blockchain
                                    </label>
                                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full 
                                        @if($transaction->blockchain_status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($transaction->blockchain_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                                        {{ ucfirst($transaction->blockchain_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Transaction Summary --}}
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                📊 Ringkasan Transaksi
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Waktu Transaksi
                                    </label>
                                    <p class="text-gray-900 dark:text-gray-100">
                                        {{ $transaction->created_at->format('d F Y') }}<br>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $transaction->created_at->format('H:i') }} WIB
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Jumlah Item
                                    </label>
                                    <p class="text-gray-900 dark:text-gray-100">
                                        {{ $transaction->orderItems->count() }} produk
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Kategori Produk
                                    </label>
                                    <div class="space-y-1">
                                        @foreach($transaction->orderItems->take(3) as $item)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            • {{ $item->product->category ?? 'Kategori tidak tersedia' }}
                                        </p>
                                        @endforeach
                                        @if($transaction->orderItems->count() > 3)
                                        <p class="text-sm text-gray-500 dark:text-gray-500">
                                            ... dan {{ $transaction->orderItems->count() - 3 }} produk lainnya
                                        </p>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Range Nilai Transaksi
                                    </label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        @php
                                            $amount = $transaction->total_price;
                                            if ($amount < 100000) echo "< Rp 100.000";
                                            elseif ($amount < 500000) echo "Rp 100.000 - 500.000";
                                            elseif ($amount < 1000000) echo "Rp 500.000 - 1.000.000";
                                            else echo "> Rp 1.000.000";
                                        @endphp
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('blockchain.verify') }}?hash={{ $transaction->blockchain_hash }}" 
                               class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Verifikasi Hash Ini
                            </a>
                            
                            <button onclick="shareTransaction()" 
                                    class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                                Share Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Information Section --}}
            <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">
                    ℹ️ Tentang Transparansi Ini
                </h4>
                <div class="text-sm text-blue-800 dark:text-blue-200 space-y-2">
                    <p>• <strong>Hash blockchain</strong> adalah bukti digital bahwa transaksi ini benar-benar terjadi dan tercatat dalam blockchain EQBR</p>
                    <p>• <strong>Data ini immutable</strong> - tidak dapat diubah atau dipalsukan oleh siapa pun</p>
                    <p>• <strong>Verifikasi publik</strong> memungkinkan siapa saja mengonfirmasi keaslian transaksi</p>
                    <p>• <strong>Privacy terjaga</strong> - data personal pembeli tetap dirahasiakan</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Hash berhasil disalin ke clipboard!');
            });
        }
        
        function shareTransaction() {
            const url = window.location.href;
            const text = `Lihat transparansi transaksi blockchain ini: ${url}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Transparansi Transaksi Blockchain',
                    text: text,
                    url: url
                });
            } else {
                copyToClipboard(url);
                alert('Link transaksi berhasil disalin!');
            }
        }
    </script>
    @endpush
</x-app-layout>