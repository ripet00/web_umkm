<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <meta name="description" content="AMPUH - Platform e-commerce UMKM terdepan dengan teknologi blockchain untuk transparansi transaksi. Belanja produk lokal berkualitas dari UMKM Indonesia dengan jaminan keamanan blockchain EQBR.">
        <meta name="keywords" content="UMKM, e-commerce, blockchain, marketplace, produk lokal, ekonomi digital, transparansi, EQBR, jual beli online, UMKM Indonesia">
        <meta name="author" content="AMPUH Team">
        <meta name="robots" content="index, follow">
        
        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="{{ config('app.name', 'AMPUH') }} - Marketplace UMKM Blockchain">
        <meta property="og:description" content="Platform e-commerce terpercaya untuk UMKM Indonesia dengan teknologi blockchain untuk transparansi penuh setiap transaksi">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="AMPUH">
        <meta property="og:locale" content="id_ID">
        
        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name', 'AMPUH') }} - Marketplace UMKM Blockchain">
        <meta name="twitter:description" content="Belanja produk UMKM dengan teknologi blockchain untuk transparansi transaksi">
        
        <!-- Additional SEO -->
        <meta name="theme-color" content="#3B82F6">
        <link rel="canonical" href="{{ url()->current() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Additional Styles -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                {{-- Support both component slot and classic section/yield --}}
                @if(isset($slot))
                    {{ $slot }}
                @endif
                @yield('content')
            </main>

            @include('partials.footer')
        </div>

        <!-- Additional Scripts -->
        @stack('scripts')
    </body>
</html>