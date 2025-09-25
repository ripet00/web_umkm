<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-6">Produk Terbaru</h2>

                    {{-- Grid untuk Produk --}}
                    @if($products->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($products as $product)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm">
                                    <div class="bg-gray-200 dark:bg-gray-700 h-48 flex items-center justify-center text-gray-500">Gambar</div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-lg truncate">{{ $product->nama_produk }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>Belum ada produk yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
