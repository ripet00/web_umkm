@props(['hash', 'status' => 'pending', 'transactionId' => null])

<div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 mt-4">
    <div class="flex items-start space-x-3">
        <div class="flex-shrink-0">
            @if($status === 'confirmed')
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @elseif($status === 'failed')
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @else
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @endif
        </div>
        
        <div class="flex-1 min-w-0">
            <h4 class="text-sm font-semibold text-gray-900 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                Status Blockchain
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($status === 'confirmed') bg-green-100 text-green-800
                    @elseif($status === 'failed') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    @if($status === 'confirmed')
                        Terkonfirmasi
                    @elseif($status === 'failed')
                        Gagal
                    @else
                        Proses
                    @endif
                </span>
            </h4>
            
            @if($hash)
                <div class="mt-2">
                    <p class="text-xs text-gray-600 mb-1">Hash Transaksi:</p>
                    <div class="bg-white border rounded p-2 font-mono text-xs text-gray-800 break-all">
                        {{ $hash }}
                    </div>
                </div>
            @endif
            
            @if($transactionId)
                <div class="mt-2">
                    <p class="text-xs text-gray-600 mb-1">ID Transaksi Blockchain:</p>
                    <div class="bg-white border rounded p-2 font-mono text-xs text-gray-800">
                        {{ $transactionId }}
                    </div>
                </div>
            @endif
            
            <div class="mt-3 text-xs text-gray-500">
                <p>🔗 Transaksi ini telah dicatat dalam blockchain EQBR untuk transparansi dan keamanan</p>
            </div>
        </div>
    </div>
</div>