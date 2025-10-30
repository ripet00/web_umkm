<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Daftar Transaksi</h3>

                    @if($orders->isEmpty())
                        <div class="text-center py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum Ada Pesanan</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda belum melakukan transaksi apapun.</p>
                            <div class="mt-6">
                                <a href="{{ route('landing') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                    Mulai Belanja
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($orders as $order)
                            @php
                                $firstItem = $order->orderItems->first();
                                $product = $firstItem ? $firstItem->product : null;
                                // try to get first product image
                                $imgPath = null;
                                if($product && isset($product->images) && $product->images->first()) {
                                    $imgPath = asset('storage/' . $product->images->first()->image_path);
                                } else {
                                    $imgPath = asset('images/placeholder.png');
                                }
                            @endphp

                            <a href="{{ route('orders.show', $order) }}" class="block p-4 rounded-lg border bg-gray-50 dark:bg-gray-700/50 dark:border-gray-700 hover:shadow-md transition">
                                <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $imgPath }}" alt="produk" class="h-12 w-12 object-cover rounded">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $product->nama_produk ?? 'Produk tidak tersedia' }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Dipesan pada: {{ $order->created_at->format('d F Y') }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-200 mt-1">Total: <span class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
                                        </div>
                                    </div>

                                    <div class="mt-4 sm:mt-0 flex items-center space-x-4">
                                        <a href="{{ route('seller.profile.show', $order->seller) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-5a2 2 0 012-2h2a2 2 0 012 2v5"></path>
                                            </svg>
                                            Kunjungi Toko
                                        </a>

                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                            @if($order->payment_status == 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif
                                            @if($order->payment_status == 'unpaid') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif
                                            @if($order->payment_status == 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 @endif">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

