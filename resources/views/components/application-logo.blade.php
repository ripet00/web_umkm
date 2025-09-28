@auth('seller')
    <a href="{{ route('seller.dashboard') }}">
        <h1 {{ $attributes->merge(['class' => 'text-2xl font-bold text-gray-800 dark:text-gray-200 tracking-wider']) }}>
            UMKM Marketchain
        </h1>
    </a>
@else
    <a href="{{ route('home') }}">
        <h1 {{ $attributes->merge(['class' => 'text-2xl font-bold text-gray-800 dark:text-gray-200 tracking-wider']) }}>
            UMKM Marketchain
        </h1>
    </a>
@endauth

