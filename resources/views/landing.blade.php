<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header dan Filter -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4">Katalog Produk</h2>
                        <form action="{{ route('home') }}" method="GET">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-2">
                                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <select name="category" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Grid Produk -->
                    @if($products->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($products as $product)
                                <a href="{{ route('products.show', $product) }}" class="block group">
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <div class="aspect-w-1 aspect-h-1 w-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                            @if($product->gambar_produk)
                                                <img src="{{ asset('storage/' . $product->gambar_produk) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-center object-cover group-hover:opacity-75">
                                            @else
                                                <div class="flex items-center justify-center h-48">
                                                    <span class="text-gray-500 text-sm">Gambar tidak tersedia</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $product->category->nama_kategori ?? 'Tanpa Kategori' }}</p>
                                            <h3 class="font-semibold text-lg truncate mt-1">{{ $product->nama_produk }}</h3>
                                            <p class="text-gray-800 dark:text-gray-200 text-md mt-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 truncate">Penjual: {{ $product->seller->nama_koperasi }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                         <div class="mt-8">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500 mt-8">Tidak ada produk yang ditemukan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
