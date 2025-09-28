<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kolom Gambar -->
                    <div>
                        <div class="aspect-w-1 aspect-h-1 w-full bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                           @if($product->gambar_produk)
                                <img src="{{ asset('storage/' . $product->gambar_produk) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover">
                           @else
                                <span class="text-gray-500">Tidak ada gambar</span>
                           @endif
                        </div>
                    </div>

                    <!-- Kolom Detail Produk -->
                    <div class="flex flex-col">
                        <div class="flex-grow">
                             <a href="{{ route('home', ['category' => $product->category->slug ?? '']) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                {{ $product->category->name ?? 'N/A' }}
                            </a>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $product->nama_produk }}</h1>
                            <p class="text-3xl font-semibold text-gray-800 dark:text-gray-200 mt-4">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                Stok: {{ $product->stok }}
                            </p>
                             <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">Deskripsi</h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-2 whitespace-pre-wrap">{{ $product->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                            <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">Informasi Penjual</h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $product->seller->nama_toko }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->seller->desa_kelurahan }}, {{ $product->seller->kecamatan }}</p>
                            </div>
                        </div>

                        <!-- Form Tambah ke Keranjang -->
                         @auth('web')
                            <div class="mt-6">
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-24">
                                            <x-input-label for="quantity" value="Jumlah" class="sr-only" />
                                            <x-text-input id="quantity" name="quantity" type="number" value="1" min="1" max="{{ $product->stok }}" class="w-full text-center" />
                                        </div>
                                        <x-primary-button type="submit" class="flex-1" :disabled="$product->stok < 1">
                                            {{ $product->stok < 1 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                                        </x-primary-button>
                                    </div>
                                    @error('quantity')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </form>
                            </div>
                         @else
                            <div class="mt-6">
                                <a href="{{ route('login') }}" class="block w-full text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold py-2 px-4 rounded-md">
                                    Login untuk Membeli
                                </a>
                            </div>
                         @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

