<x-app-layout>
    <!-- Hero Carousel Section -->
    <div class="relative">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="relative h-[400px] md:h-[500px] bg-gradient-to-r from-indigo-600 to-purple-600">
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-2xl">
                                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                                        Selamat Datang di Marketplace Kami
                                    </h1>
                                    <p class="text-xl text-white/90 mb-8">
                                        Temukan produk berkualitas dari koperasi terpercaya
                                    </p>
                                    <a href="#products" class="inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                        Jelajahi Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <div class="relative h-[400px] md:h-[500px] bg-gradient-to-r from-green-600 to-teal-600">
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-2xl">
                                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                                        Produk Lokal Berkualitas
                                    </h1>
                                    <p class="text-xl text-white/90 mb-8">
                                        Dukung UMKM dan koperasi lokal dengan berbelanja di sini
                                    </p>
                                    <a href="#products" class="inline-block px-8 py-3 bg-white text-green-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                        Belanja Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <div class="relative h-[400px] md:h-[500px] bg-gradient-to-r from-orange-600 to-red-600">
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-2xl">
                                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                                        Promo Spesial
                                    </h1>
                                    <p class="text-xl text-white/90 mb-8">
                                        Dapatkan penawaran terbaik untuk produk pilihan
                                    </p>
                                    <a href="#products" class="inline-block px-8 py-3 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                        Lihat Promo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Custom Navigation Buttons -->
            <button class="hero-button-prev absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 flex items-center justify-center bg-white/30 hover:bg-white/50 backdrop-blur-sm rounded transition-all duration-300 group">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button class="hero-button-next absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 flex items-center justify-center bg-white/30 hover:bg-white/50 backdrop-blur-sm rounded transition-all duration-300 group">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <!-- Pagination -->
            <div class="swiper-pagination !bottom-6"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 bg-white dark:bg-gray-900" id="products">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header dan Filter -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-gray-100">Katalog Produk</h2>
                <form action="{{ route('home') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>
                        <div>
                            <select name="category" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Grid Produk -->
            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product) }}" class="block group">
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 bg-white dark:bg-gray-800">
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
                                    <h3 class="font-semibold text-lg truncate mt-1 text-gray-900 dark:text-gray-100">{{ $product->nama_produk }}</h3>
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
                <p class="text-center text-gray-500 dark:text-gray-400 mt-8">Tidak ada produk yang ditemukan.</p>
            @endif
        </div>
    </div>

    <!-- Swiper JS -->
    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .heroSwiper .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: white;
            opacity: 0.5;
            transition: all 0.3s ease;
        }
        .heroSwiper .swiper-pagination-bullet-active {
            opacity: 1;
            width: 32px;
            border-radius: 6px;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            speed: 800,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.hero-button-next',
                prevEl: '.hero-button-prev',
            },
        });
    </script>
    @endpush
</x-app-layout>