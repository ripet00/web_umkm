<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $seller->nama_koperasi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Profil Seller -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <!-- Foto Profil -->
                        <div class="flex-shrink-0">
                            @if($seller->foto_profil)
                                <img src="{{ asset('storage/' . $seller->foto_profil) }}" 
                                     alt="{{ $seller->nama_koperasi }}" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-600">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-5a2 2 0 012-2h2a2 2 0 012 2v5"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Informasi Toko -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $seller->nama_koperasi }}
                            </h1>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600 dark:text-gray-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $seller->desa_kelurahan }}, {{ $seller->kecamatan }}</span>
                                </div>
                                
                                @if($seller->no_hp)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>{{ $seller->no_hp }}</span>
                                </div>
                                @endif
                                
                                @if($seller->alamat_toko)
                                <div class="flex items-center gap-2 md:col-span-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-5a2 2 0 012-2h2a2 2 0 012 2v5"></path>
                                    </svg>
                                    <span>{{ $seller->alamat_toko }}</span>
                                </div>
                                @endif
                            </div>

                            @if($seller->deskripsi_toko)
                            <div class="mt-4">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $seller->deskripsi_toko }}
                                </p>
                            </div>
                            @endif

                            <!-- Statistik -->
                            <div class="mt-6 flex gap-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalProducts }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Produk</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $seller->jenis_usaha }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Jenis Usaha</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk-produk Seller -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Produk Tersedia
                    </h3>

                    @if($products->isEmpty())
                        <div class="text-center py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum Ada Produk</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Toko ini belum memiliki produk yang dijual.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($products as $product)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                                <a href="{{ route('products.show', $product) }}">
                                    <!-- Gambar Produk -->
                                    <div class="aspect-square relative overflow-hidden">
                                        @if($product->images->first())
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                 alt="{{ $product->nama_produk }}" 
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                                        @else
                                            <div class="w-full h-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Info Produk -->
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-2 line-clamp-2">
                                            {{ $product->nama_produk }}
                                        </h4>
                                        
                                        @if($product->category)
                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300 mb-2">
                                            {{ $product->category->name }}
                                        </span>
                                        @endif
                                        
                                        <div class="flex items-center justify-between">
                                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                Stok: {{ $product->stok }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>