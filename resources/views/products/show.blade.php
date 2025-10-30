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
                                {{ $product->category->name ?? 'N/A' }}
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
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Informasi Penjual</h3>
                                    <a href="{{ route('seller.profile.show', $product->seller) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-5a2 2 0 012-2h2a2 2 0 012 2v5"></path>
                                        </svg>
                                        Kunjungi Toko
                                    </a>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ $product->seller->nama_koperasi }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $product->seller->desa_kelurahan }}, {{ $product->seller->kecamatan }}
                                </p>
                            </div>
                        </div>

                        <!-- Form Tambah ke Keranjang & Wishlist -->
                        @auth('web')
                            <div class="mt-6">
                                <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="flex items-center space-x-4 mb-3">
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
                                        
                                        {{-- Wishlist Button --}}
                                        <button type="button" 
                                                onclick="toggleWishlistDetail({{ $product->id }})" 
                                                id="wishlist-btn-detail"
                                                class="flex-shrink-0 p-3 border-2 {{ $product->isInWishlist() ? 'border-pink-500 bg-pink-50 dark:bg-pink-900/20' : 'border-gray-300 dark:border-gray-600' }} rounded-lg hover:border-pink-500 dark:hover:border-pink-500 transition group/wishlist"
                                                title="{{ $product->isInWishlist() ? 'Hapus dari wishlist' : 'Tambah ke wishlist' }}">
                                            <svg class="w-6 h-6 {{ $product->isInWishlist() ? 'text-pink-500 fill-current' : 'text-gray-400' }} group-hover/wishlist:scale-110 transition-transform" 
                                                 fill="none" 
                                                 stroke="currentColor" 
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    @error('quantity')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </form>
                            </div>
                        @else
                            <div class="mt-6 space-y-3">
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

    {{-- Toast Notification --}}
    <div id="toast" class="hidden fixed bottom-4 right-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 max-w-sm z-50 border-l-4 transition">
        <div class="flex items-center">
            <div id="toast-icon" class="flex-shrink-0 mr-3"></div>
            <p id="toast-message" class="text-sm font-medium text-gray-900 dark:text-gray-100"></p>
        </div>
    </div>

    @push('scripts')
    <script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

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

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            document.getElementById('prevImage')?.click();
        } else if (e.key === 'ArrowRight') {
            document.getElementById('nextImage')?.click();
        }
    });

    // Toggle Wishlist Function
    function toggleWishlistDetail(productId) {
        if (!csrfToken) {
            alert('Please login first');
            window.location.href = '/login';
            return;
        }
        
        fetch('/wishlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const btn = document.getElementById('wishlist-btn-detail');
                const svg = btn?.querySelector('svg');
                
                if (data.action === 'added') {
                    btn.classList.add('border-pink-500', 'bg-pink-50', 'dark:bg-pink-900/20');
                    btn.classList.remove('border-gray-300', 'dark:border-gray-600');
                    svg.classList.add('text-pink-500', 'fill-current');
                    svg.classList.remove('text-gray-400');
                    btn.setAttribute('title', 'Hapus dari wishlist');
                    showToast('Ditambahkan ke wishlist ❤️', 'success');
                } else {
                    btn.classList.remove('border-pink-500', 'bg-pink-50', 'dark:bg-pink-900/20');
                    btn.classList.add('border-gray-300', 'dark:border-gray-600');
                    svg.classList.remove('text-pink-500', 'fill-current');
                    svg.classList.add('text-gray-400');
                    btn.setAttribute('title', 'Tambah ke wishlist');
                    showToast('Dihapus dari wishlist', 'success');
                }
            } else {
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'error');
        });
    }

    // Add to Cart Handler
    const addToCartForm = document.getElementById('add-to-cart-form');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Produk ditambahkan ke keranjang 🛒', 'success');
                    // Update cart count if you have cart badge in navbar
                    updateCartCount();
                } else {
                    showToast(data.message || 'Gagal menambahkan ke keranjang', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        });
    }

    // Show Toast Notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        if (!toast) return;
        
        const toastMessage = document.getElementById('toast-message');
        const toastIcon = document.getElementById('toast-icon');
        
        toastMessage.textContent = message;
        
        if (type === 'success') {
            toast.className = 'fixed bottom-4 right-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 max-w-sm z-50 border-l-4 border-green-500 transition';
            toastIcon.innerHTML = '<svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
        } else {
            toast.className = 'fixed bottom-4 right-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 max-w-sm z-50 border-l-4 border-red-500 transition';
            toastIcon.innerHTML = '<svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>';
        }
        
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }

    // Update cart count (optional - if you have cart badge)
    function updateCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge && data.count !== undefined) {
                    cartBadge.textContent = data.count;
                    cartBadge.classList.remove('hidden');
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }
    </script>
    @endpush
</x-app-layout>