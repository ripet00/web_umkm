<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wishlist Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header Info --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        💖 Wishlist Favorit
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ $wishlistProducts->total() }} produk tersimpan
                    </p>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Lanjut Belanja
                </a>
            </div>

            {{-- Wishlist Products Grid --}}
            @if($wishlistProducts->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($wishlistProducts as $product)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition group relative">
                            
                            {{-- Remove from Wishlist Button --}}
                            <button onclick="removeFromWishlist({{ $product->id }})" 
                                    class="absolute top-3 right-3 z-10 p-2 bg-white/90 dark:bg-gray-800/90 rounded-full shadow-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition group/btn">
                                <svg class="w-5 h-5 text-pink-500 group-hover/btn:text-red-600 dark:text-pink-400 dark:group-hover/btn:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            {{-- Product Image --}}
                            <a href="{{ route('products.show', $product) }}" class="block">
                                <div class="aspect-square bg-gray-100 dark:bg-gray-700 overflow-hidden">
                                    @if($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                             alt="{{ $product->nama_produk }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            {{-- Product Info --}}
                            <div class="p-4">
                                <a href="{{ route('products.show', $product) }}">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 mb-2">
                                        {{ $product->nama_produk }}
                                    </h4>
                                </a>
                                
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </div>

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </span>
                                    @if($product->stok > 0)
                                        <span class="text-xs text-green-600 dark:text-green-400">
                                            Stok: {{ $product->stok }}
                                        </span>
                                    @else
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            Habis
                                        </span>
                                    @endif
                                </div>

                                {{-- Add to Cart Button --}}
                                @if($product->stok > 0)
                                    <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-2 px-4 rounded-lg text-sm font-medium cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $wishlistProducts->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Wishlist Masih Kosong
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Mulai tambahkan produk favorit Anda ke wishlist
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Jelajahi Produk
                    </a>
                </div>
            @endif

        </div>
    </div>

    {{-- Toast Notification --}}
    <div id="toast" class="hidden fixed bottom-4 right-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 max-w-sm z-50 border-l-4 transition">
        <div class="flex items-center">
            <div id="toast-icon" class="flex-shrink-0 mr-3"></div>
            <p id="toast-message" class="text-sm font-medium text-gray-900 dark:text-gray-100"></p>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Remove from Wishlist
        function removeFromWishlist(productId) {
            if (!confirm('Hapus produk dari wishlist?')) return;

            fetch(`/wishlist/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        }

        // Add to Cart
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Produk berhasil ditambahkan ke keranjang', 'success');
                        // Update cart count if exists
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
        });

        // Show Toast Notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');
            
            // Set message
            toastMessage.textContent = message;
            
            // Set icon and color based on type
            if (type === 'success') {
                toast.className = 'fixed bottom-4 right-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 max-w-sm z-50 border-l-4 border-green-500 transition';
                toastIcon.innerHTML = '<svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
            } else {
                toast.className = 'fixed bottom-4 right-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 max-w-sm z-50 border-l-4 border-red-500 transition';
                toastIcon.innerHTML = '<svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>';
            }
            
            // Show toast
            toast.classList.remove('hidden');
            
            // Hide after 3 seconds
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Update cart count in navbar
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const cartBadge = document.querySelector('.cart-count');
                    if (cartBadge && data.count) {
                        cartBadge.textContent = data.count;
                    }
                })
                .catch(error => console.error('Error updating cart count:', error));
        }
    </script>
</x-app-layout>