<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'MarketChain') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
        {{-- Kontainer untuk memusatkan konten secara vertikal dan horizontal --}}
        <div class="flex items-center justify-center min-h-screen">
            {{-- Styling Profesional untuk Teks --}}
            <h1 class="text-5xl md:text-7xl font-extrabold text-gray-800 dark:text-white tracking-wider animate-pulse">
                UMKM
            </h1>
        </div>

        <script>
            // Redirect ke halaman utama setelah 3 detik
            setTimeout(function() {
                window.location.href = "{{ route('home') }}";
            }, 3000); // 3000 milidetik = 3 detik
        </script>
    </body>
</html>
