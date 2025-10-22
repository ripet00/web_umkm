<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Penjual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Profil Seller --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center space-x-6">
                        {{-- Avatar/Logo Toko --}}
                        <div class="flex-shrink-0">
                            @if(Auth::guard('seller')->user()->logo)
                                <img src="{{ asset('storage/' . Auth::guard('seller')->user()->logo) }}" 
                                     alt="Logo Toko" 
                                     class="h-24 w-24 rounded-full object-cover border-4 border-indigo-500">
                            @else
                                <div class="h-24 w-24 rounded-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold">
                                    {{ strtoupper(substr(Auth::guard('seller')->user()->nama_toko ?? 'T', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        {{-- Info Profil --}}
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ Auth::guard('seller')->user()->nama_koperasi ?? 'Nama Toko' }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                {{ Auth::guard('seller')->user()->no_hp ?? 'Nomor telepon belum diatur' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                                Bergabung sejak {{ Auth::guard('seller')->user()->created_at->format('d F Y') }}
                            </p>
                            <div class="mt-3">
                                <a href="{{ route('seller.profile.edit') }}" 
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 text-sm font-medium">
                                    Edit Profil →
                                </a>
                            </div>
                        </div>

                        {{-- Wallet Address (Web3) --}}
                        @if(Auth::guard('seller')->user()->wallet_address)
                        <div class="flex-shrink-0">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-4 rounded-lg text-white">
                                <p class="text-xs uppercase tracking-wide mb-1">Wallet Connected</p>
                                <p class="font-mono text-sm">
                                    {{ substr(Auth::guard('seller')->user()->wallet_address, 0, 6) }}...{{ substr(Auth::guard('seller')->user()->wallet_address, -4) }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Total Produk --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produk</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ Auth::guard('seller')->user()->products()->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Pesanan --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pesanan</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ Auth::guard('seller')->user()->orders()->count() ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pendapatan Bulan Ini --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendapatan Bulan Ini</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format(Auth::guard('seller')->user()->orders()->whereMonth('created_at', now()->month)->sum('total_price') ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stok Menipis --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Stok Menipis</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ Auth::guard('seller')->user()->products()->where('stok', '<', 10)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('seller.products.create') }}" 
                           class="flex flex-col items-center justify-center p-6 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition">
                            <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Tambah Produk</span>
                        </a>

                        <a href="{{ route('seller.products.index') }}" 
                           class="flex flex-col items-center justify-center p-6 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                            <svg class="h-8 w-8 text-green-600 dark:text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Kelola Produk</span>
                        </a>

                        <a href="{{ route('seller.orders.index') }}" 
                           class="flex flex-col items-center justify-center p-6 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition">
                            <svg class="h-8 w-8 text-yellow-600 dark:text-yellow-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Lihat Pesanan</span>
                        </a>

                        <a href="#" 
                           class="flex flex-col items-center justify-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition">
                            <svg class="h-8 w-8 text-purple-600 dark:text-purple-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Laporan Penjualan</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Recent Activities & Low Stock Alert --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Pesanan Terbaru --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pesanan Terbaru</h3>
                        <div class="space-y-3">
                            @php
                                $recentOrders = Auth::guard('seller')->user()->orders()->latest()->take(5)->get();
                            @endphp
                            @forelse($recentOrders as $order)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Order #{{ $order->id }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($order->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Belum ada pesanan</p>
                            @endforelse
                        </div>
                        <a href="{{ route('seller.orders.index') }}" 
                           class="block text-center mt-4 text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                            Lihat Semua Pesanan →
                        </a>
                    </div>
                </div>

                {{-- Produk Stok Menipis --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">⚠️ Stok Menipis</h3>
                        <div class="space-y-3">
                            @php
                                $lowStockProducts = Auth::guard('seller')->user()->products()->where('stok', '<', 10)->orderBy('stok', 'asc')->take(5)->get();
                            @endphp
                            @forelse($lowStockProducts as $product)
                                <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        @if($product->primaryImage)
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                                 alt="{{ $product->nama_produk }}" 
                                                 class="h-10 w-10 object-cover rounded-md">
                                        @else
                                            <div class="h-10 w-10 bg-gray-200 dark:bg-gray-700 rounded-md"></div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->nama_produk }}</p>
                                            <p class="text-xs text-red-600 dark:text-red-400">Stok tersisa: {{ $product->stok }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('seller.products.edit', $product) }}" 
                                       class="text-xs text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 font-medium">
                                        Restok
                                    </a>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Semua produk stoknya aman ✓</p>
                            @endforelse
                        </div>
                        <a href="{{ route('seller.products.index') }}" 
                           class="block text-center mt-4 text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                            Kelola Semua Produk →
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-seller-layout>