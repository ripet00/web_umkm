<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pesanan #' . $order->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
             @if(request()->get('status') == 'success')
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Pembayaran Berhasil!</strong>
                    <span class="block sm:inline">Terima kasih telah berbelanja.</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold">Pesanan #{{ $order->id }}</h3>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm leading-5 font-semibold rounded-full 
                            @if($order->status == 'paid') bg-green-100 text-green-800 @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    
                    <h4 class="text-lg font-semibold mb-4 border-b pb-2">Detail Item</h4>
                    <div class="space-y-4 mb-6">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $item->product->nama_produk }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->quantity }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-medium">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Blockchain Status Section --}}
                    @if($order->payment_status === 'paid')
                        <x-blockchain-status 
                            :hash="$order->blockchain_hash"
                            :status="$order->blockchain_status ?? 'pending'"
                            :transactionId="$order->blockchain_transaction_id"
                        />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
