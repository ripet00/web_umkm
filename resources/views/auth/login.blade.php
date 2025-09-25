<x-guest-layout>
    <div class="w-full max-w-4xl mx-auto px-6 py-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Masuk Sebagai</h1>
            <p class="text-gray-600 dark:text-gray-400">Pilih peran Anda untuk melanjutkan</p>
        </div>

        <div class="flex flex-col md:flex-row justify-center items-center gap-8">
            <!-- User Card -->
            <a href="{{ route('user.login') }}" class="w-full md:w-64">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg p-8 text-center transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                    <!-- Heroicon: user -->
                    <svg class="w-16 h-16 mx-auto text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <h2 class="mt-4 text-xl font-semibold text-gray-700 dark:text-gray-200">User</h2>
                </div>
            </a>

            <!-- Koperasi/Seller Card -->
            <a href="{{ route('seller.login') }}" class="w-full md:w-64">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg p-8 text-center transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                    <!-- Heroicon: building-storefront -->
                    <svg class="w-16 h-16 mx-auto text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5A.75.75 0 0 1 14.25 12h.01M6.375 21v-7.5a.75.75 0 0 0-.75-.75h-.01M12 3v.01M3 3v.01M3 21v.01M21 3v.01M21 21v.01M12 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-3 18.75a.75.75 0 0 0 .75.75h.01a.75.75 0 0 0 .75-.75v-.01a.75.75 0 0 0-.75-.75h-.01a.75.75 0 0 0-.75.75v.01ZM12 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <h2 class="mt-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Koperasi</h2>
                </div>
            </a>
        </div>
    </div>
</x-guest-layout>