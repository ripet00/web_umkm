<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Profil User --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center space-x-6">
                        {{-- Avatar --}}
                        <div class="flex-shrink-0">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     alt="Avatar" 
                                     class="h-24 w-24 rounded-full object-cover border-4 border-indigo-500">
                            @else
                                <div class="h-24 w-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        {{-- Info Profil --}}
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $user->name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                {{ $user->email }}
                            </p>
                            @if($user->no_hp)
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                                📱 {{ $user->no_hp }}
                            </p>
                            @endif
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                                Member sejak {{ $user->created_at->format('d F Y') }}
                            </p>
                            <div class="mt-3 flex items-center gap-3">
                                <a href="{{ route('profile.edit') }}" 
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 text-sm font-medium">
                                    Edit Profil →
                                </a>
                                @if($user->email_verified_at)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Verified
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Wallet Balance (Web3) --}}
                        @if($user->wallet_address)
                        <div class="flex-shrink-0">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-4 rounded-lg text-white">
                                <p class="text-xs uppercase tracking-wide mb-1">Wallet Balance</p>
                                <p class="text-2xl font-bold">0.00 ETH</p>
                                <p class="font-mono text-xs mt-2 opacity-75">
                                    {{ substr($user->wallet_address, 0, 6) }}...{{ substr($user->wallet_address, -4) }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Total Pesanan --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pesanan</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $totalOrders }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pesanan Aktif --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pesanan Aktif</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $activeOrders }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Belanja --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Belanja</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($totalSpending, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wishlist --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Wishlist</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $wishlistCount }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Menu Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition group">
                            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Belanja</span>
                        </a>

                        <a href="{{ route('orders.index') }}" class="flex flex-col items-center justify-center p-6 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition group">
                            <svg class="h-8 w-8 text-green-600 dark:text-green-400 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Pesanan Saya</span>
                        </a>

                        <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center justify-center p-6 bg-pink-50 dark:bg-pink-900/20 rounded-lg hover:bg-pink-100 dark:hover:bg-pink-900/30 transition group">
                            <svg class="h-8 w-8 text-pink-600 dark:text-pink-400 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Wishlist</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Activity Sections --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Pesanan Terbaru --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pesanan Terbaru</h3>
                            <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 font-medium">
                                Lihat Semua →
                            </a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recentOrders as $order)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition cursor-pointer">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                #{{ $order->order_number }}
                                            </p>
                                            <span class="text-xs px-2 py-1 rounded-full bg-{{ $order->status_badge_color }}-100 text-{{ $order->status_badge_color }}-800 dark:bg-{{ $order->status_badge_color }}-900 dark:text-{{ $order->status_badge_color }}-300">
                                                {{ $order->status_label }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            <span>{{ $order->orderItems->count() }} produk</span>
                                            <span>•</span>
                                            <span>{{ $order->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center justify-between mt-2">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </p>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                @if($order->payment_status == 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                @elseif($order->payment_status == 'unpaid') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                                @endif">
                                                {{ $order->payment_status_label }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada pesanan</p>
                                    <a href="{{ route('home') }}" class="mt-3 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 font-medium">
                                        Mulai Belanja
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Produk Wishlist --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Wishlist Favorit</h3>
                                <a href="{{ route('wishlist.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 font-medium">
                                    Lihat Semua →
                                </a>
                        </div>
                        <div class="space-y-3">
                            @forelse($wishlistProducts as $product)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                    <div class="flex-shrink-0">
                                        @if($product->primaryImage)
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                                alt="{{ $product->nama_produk }}" 
                                                class="h-16 w-16 object-cover rounded-lg">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('products.show', $product) }}">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate hover:text-indigo-600 dark:hover:text-indigo-400">
                                                {{ $product->nama_produk }}
                                            </p>
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </p>
                                        <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <button onclick="toggleWishlist({{ $product->id }})" class="flex-shrink-0 p-2 text-pink-500 hover:text-pink-700 dark:text-pink-400 dark:hover:text-pink-300 transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Wishlist kosong</p>
                                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Simpan produk favoritmu di sini</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- JavaScript untuk wishlist --}}
                <script>
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                function toggleWishlist(productId) {
                    fetch('/wishlist/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
                </script>

            </div>

            {{-- Rekomendasi Produk --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Rekomendasi Untuk Anda</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Produk pilihan yang mungkin Anda suka</p>
                        </div>
                        <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 font-medium">
                            Lihat Semua →
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @forelse($recommendedProducts as $product)
                        <a href="{{ route('products.show', $product) }}" class="bg-gray-50 dark:bg-gray-700 rounded-xl overflow-hidden hover:shadow-lg transition group">
                            <div class="aspect-square bg-gray-200 dark:bg-gray-600 overflow-hidden">
                                @if($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                         alt="{{ $product->nama_produk }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                    {{ $product->nama_produk }}
                                </h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                    <button class="p-1 text-gray-400 hover:text-pink-500 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Belum ada produk tersedia</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>