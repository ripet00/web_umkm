<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <meta name="description" content="Dashboard Seller AMPUH - Kelola toko UMKM Anda dengan teknologi blockchain. Pantau penjualan, kelola produk, dan lihat transparansi transaksi dengan blockchain EQBR.">
        <meta name="keywords" content="dashboard seller UMKM, kelola toko online, blockchain penjualan, UMKM digital, seller marketplace, transparansi blockchain">
        <meta name="author" content="AMPUH Team">
        <meta name="robots" content="noindex, nofollow">
        
        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="Dashboard Seller - {{ config('app.name', 'AMPUH') }}">
        <meta property="og:description" content="Kelola bisnis UMKM Anda dengan platform e-commerce blockchain terpercaya">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="AMPUH">
        
        <!-- Additional SEO -->
        <meta name="theme-color" content="#3B82F6">

        <title>{{ config('app.name', 'Laravel') }} - Seller Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.seller-navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{-- Support both component slot and classic section/yield --}}
                @if(isset($slot))
                    {{ $slot }}
                @endif
                @yield('content')
            </main>
        </div>
    </body>
</html>
