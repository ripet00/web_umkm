<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kolom Gambar -->
                    <div>
                        <!-- Main Image dengan Navigation Arrows -->
                        <div class="relative aspect-square w-full bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden mb-4 group">
                            @if($product->images->count() > 0)
                                <img id="mainImage" 
                                     src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                     alt="{{ $product->nama_produk }}" 
                                     class="w-full h-full object-cover"
                                     data-current-index="0">
                                
                                <!-- Navigation Arrows -->
                                @if($product->images->count() > 1)
                                <button type="button" 
                                        id="prevImage"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button type="button" 
                                        id="nextImage"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                </div>
                            @endif
                        </div>

                        <!-- Thumbnail Gallery -->
                        @if($product->images->count() > 1)
                        <div class="grid grid-cols-5 gap-2" id="thumbnailGallery">
                            @foreach($product->images as $index => $image)
                            <button type="button" 
                                    onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}', {{ $index }})"
                                    class="aspect-square border-2 rounded-lg overflow-hidden hover:border-indigo-500 transition {{ $image->is_primary ? 'border-indigo-500' : 'border-gray-300 dark:border-gray-600' }}"
                                    data-image-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="Thumbnail" 
                                     class="w-full h-full object-cover">
                            </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Kolom Detail Produk -->
                    <div class="flex flex-col">
                        <div class="flex-grow">
                            <a href="{{ route('home', ['category' => $product->category->slug ?? '']) }}" 
                               class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                {{ $product->category->nama_kategori ?? 'N/A' }}
                            </a>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                                {{ $product->nama_produk }}
                            </h1>
                            <p class="text-3xl font-semibold text-gray-800 dark:text-gray-200 mt-4">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                Stok: {{ $product->stok }}
                            </p>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Deskripsi</h3>
                                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap leading-relaxed">{{ $product->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Informasi Penjual</h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ $product->seller->nama_koperasi }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $product->seller->desa_kelurahan }}, {{ $product->seller->kecamatan }}
                                </p>
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
                                            <x-text-input id="quantity" 
                                                          name="quantity" 
                                                          type="number" 
                                                          value="1" 
                                                          min="1" 
                                                          max="{{ $product->stok }}" 
                                                          class="w-full text-center" />
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
                                <a href="{{ route('login') }}" 
                                   class="block w-full text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                    Login untuk Membeli
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    // Array untuk menyimpan semua URL gambar
    const imageUrls = [
        @foreach($product->images as $image)
            "{{ asset('storage/' . $image->image_path) }}",
        @endforeach
    ];

    let currentIndex = 0;

    function changeMainImage(imageSrc, index) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = imageSrc;
        currentIndex = index;
        
        updateThumbnailBorders();
    }

    function updateThumbnailBorders() {
        const thumbnails = document.querySelectorAll('[data-image-index]');
        thumbnails.forEach((thumb, idx) => {
            if (idx === currentIndex) {
                thumb.classList.remove('border-gray-300', 'dark:border-gray-600');
                thumb.classList.add('border-indigo-500');
            } else {
                thumb.classList.remove('border-indigo-500');
                thumb.classList.add('border-gray-300', 'dark:border-gray-600');
            }
        });
    }

    // Navigation dengan tombol prev/next
    document.getElementById('prevImage')?.addEventListener('click', function() {
        currentIndex = (currentIndex - 1 + imageUrls.length) % imageUrls.length;
        changeMainImage(imageUrls[currentIndex], currentIndex);
    });

    document.getElementById('nextImage')?.addEventListener('click', function() {
        currentIndex = (currentIndex + 1) % imageUrls.length;
        changeMainImage(imageUrls[currentIndex], currentIndex);
    });

    // Keyboard navigation (optional)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            document.getElementById('prevImage')?.click();
        } else if (e.key === 'ArrowRight') {
            document.getElementById('nextImage')?.click();
        }
    });
    </script>
    @endpush
</x-app-layout>