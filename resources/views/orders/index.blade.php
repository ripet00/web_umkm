<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Riwayat Pesanan</h3>
                    <div class="space-y-4">
                        @forelse($orders as $order)
                            <a href="{{ route('orders.show', $order) }}" class="block p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">Pesanan #{{ $order->id }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($order->status == 'paid') bg-green-100 text-green-800 @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p>Anda belum memiliki riwayat pesanan.</p>
                        @endforelse
                    </div>
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
