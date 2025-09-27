<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 mb-6">
                        @php $total = 0; @endphp
                        @foreach($cart->items as $item)
                            @php $subtotal = $item->product->harga * $item->quantity; $total += $subtotal; @endphp
                            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                                <div>
                                    <p class="font-semibold">{{ $item->product->nama_produk }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Jumlah: {{ $item->quantity }}</p>
                                </div>
                                <p class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                         <form action="{{ route('orders.process') }}" method="POST">
                            @csrf
                            <x-primary-button class="w-full justify-center text-lg">
                                {{ __('Lanjutkan Pembayaran') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
