{{-- filepath: resources/views/sellers/orders/index.blade.php --}}
@php
    // Cek apakah user login sebagai seller
    $isSeller = Auth::guard('seller')->check();
@endphp

@if($isSeller)
    <x-seller-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Pesanan') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            {{-- Pastikan route show sudah ada, jika belum hapus link ini --}}
                                            {{-- <a href="{{ route('seller.orders.show', $order->id) }}" class="text-blue-500">Detail</a> --}}
                                            <span class="text-gray-400">Detail</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-seller-layout>
@else
    <div class="text-center py-20">
        <h2 class="text-2xl font-bold text-red-600">Akses hanya untuk Seller.</h2>
    </div>
@endif