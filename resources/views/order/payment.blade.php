<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
            Lakukan Pembayaran
        </h2>
    </x-slot>

    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('midtrans.client_key') }}"></script>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Selesaikan Pembayaran Anda</h2>
                <p class="text-gray-600 mb-6">Satu langkah lagi untuk menyelesaikan pesanan #{{ $order->id }}</p>

                <button id="pay-button" class="inline-flex items-center px-8 py-4 bg-green-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-600">
                    Bayar Sekarang (Total: Rp {{ number_format($order->total_amount) }})
                </button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
      // Cari tombol bayar
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Jalankan Snap pop-up saat tombol diklik
        snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            /* Anda bisa tambahkan logika di sini jika pembayaran sukses */
            console.log(result);
            alert("payment success!"); 
            window.location.href = '/'; // Arahkan ke halaman utama
          },
          onPending: function(result){
            /* Anda bisa tambahkan logika di sini jika pembayaran pending */
            console.log(result);
            alert("waiting your payment!");
          },
          onError: function(result){
            /* Anda bisa tambahkan logika di sini jika pembayaran gagal */
            console.log(result);
            alert("payment failed!");
          },
          onClose: function(){
            /* Anda bisa tambahkan logika di sini jika pop-up ditutup tanpa bayar */
            alert('you closed the popup without finishing the payment');
          }
        })
      });
    </script>
</x-app-layout>