<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 text-center">
                    <h3 class="text-2xl font-bold mb-2">Selesaikan Pembayaran Anda</h3>
                    <p class="text-gray-500 dark:text-gray-400">Pesanan: {{ $order->order_number }}</p>
                    <p class="text-3xl font-bold my-4">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    <p class="mb-6">Klik tombol di bawah ini untuk melanjutkan ke halaman pembayaran yang aman.</p>
                    
                    <button id="pay-button" class="w-full max-w-xs mx-auto justify-center text-lg inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $order->client_key }}"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $snapToken }}', {
          // Optional
          onSuccess: function(result){
            /* You may add your own implementation here */
            window.location.href = "{{ route('orders.show', $order) }}?status=success";
          },
          // Optional
          onPending: function(result){
            /* You may add your own implementation here */
            window.location.href = "{{ route('orders.show', $order) }}?status=pending";
          },
          // Optional
          onError: function(result){
            /* You may add your own implementation here */
             window.location.href = "{{ route('orders.show', $order) }}?status=error";
          }
        });
      };
    </script>
</x-app-layout>

