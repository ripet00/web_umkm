<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'AMPUH') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
        {{-- Kontainer untuk memusatkan konten secara vertikal dan horizontal --}}
        <div class="flex flex-col items-center justify-center min-h-screen">
            {{-- Styling Profesional untuk Teks --}}
            <h1 class="text-5xl md:text-7xl font-extrabold text-gray-800 dark:text-white tracking-wider animate-pulse">
                AMPUH
            </h1>
            <br>
            <h3 class="text-xl md:text-2xl font-semibold text-gray-600 dark:text-gray-300 tracking-wide">
                Aplikasi Merah Putih Universitas Hasanuddin
            </h3>
        </div>

        <script>
            // Redirect ke halaman utama setelah 3 detik
            setTimeout(function() {
                window.location.href = "{{ route('home') }}";
            }, 3000); // 3000 milidetik = 3 detik
        </script>
    </body>
</html>
