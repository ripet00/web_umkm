<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Gambar Produk -->
                        <div>
                            <div class="aspect-w-1 aspect-h-1 w-full bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                                @if($product->gambar_produk)
                                    <img src="{{ asset('storage/' . $product->gambar_produk) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-center object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <span class="text-gray-500">Gambar tidak tersedia</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Info Produk -->
                        <div class="flex flex-col">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $product->nama_produk }}</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                Kategori: <a href="{{ route('home', ['category' => $product->category->slug]) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $product->category->nama_kategori ?? 'N/A' }}</a>
                            </p>

                            <p class="text-3xl text-gray-900 dark:text-gray-100 mt-4">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Deskripsi</h3>
                                <p class="text-base text-gray-600 dark:text-gray-400 mt-2">
                                    {{ $product->deskripsi ?: 'Tidak ada deskripsi.' }}
                                </p>
                            </div>

                            <div class="mt-auto pt-6">
                                <!-- Info Penjual -->
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                     <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informasi Penjual</h3>
                                     <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                         <strong>{{ $product->seller->nama_koperasi }}</strong>
                                     </p>
                                     <p class="text-sm text-gray-600 dark:text-gray-400">
                                         {{ $product->seller->desa_kelurahan }}, {{ $product->seller->kecamatan }}
                                     </p>
                                </div>
                                <div class="mt-4">
                                     <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Stok tersedia: {{ $product->stok }}
                                     </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
