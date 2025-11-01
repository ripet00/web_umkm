<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <meta name="description" content="Login ke AMPUH - Platform e-commerce UMKM dengan teknologi blockchain. Bergabung dengan ribuan UMKM Indonesia dalam ekosistem perdagangan digital yang transparan dan aman.">
        <meta name="keywords" content="login UMKM, daftar UMKM, marketplace blockchain, e-commerce Indonesia, UMKM digital, blockchain EQBR">
        <meta name="author" content="AMPUH Team">
        <meta name="robots" content="index, follow">
        
        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="Login - {{ config('app.name', 'AMPUH') }} Marketplace UMKM">
        <meta property="og:description" content="Masuk ke platform e-commerce UMKM terpercaya dengan teknologi blockchain untuk transaksi yang transparan">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="AMPUH">
        
        <!-- Additional SEO -->
        <meta name="theme-color" content="#3B82F6">
        <link rel="canonical" href="{{ url()->current() }}">

        <title>{{ config('app.name', 'AMPUH') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

