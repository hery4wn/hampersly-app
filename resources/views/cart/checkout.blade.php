<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Konfirmasi Pesanan</h3>

                    <form action="{{ route('order.place') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h4 class="text-lg font-semibold mb-4">Alamat Pengiriman</h4>
            <div>
                <label for="shipping_address" class="block font-medium text-sm text-gray-700">Alamat Lengkap</label>
                <textarea id="shipping_address" name="shipping_address" rows="4" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('shipping_address') }}</textarea>
            </div>

            <h4 class="text-lg font-semibold mb-4 mt-6">Metode Pengiriman</h4>
            <div class="space-y-3">
                @foreach($shippingOptions as $key => $option)
                <label class="flex items-center border p-4 rounded-lg has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-400">
                    <input type="radio" name="shipping_option" value="{{ $key }}" required class="text-[#FF9898] focus:ring-[#FF9898]">
                    <span class="ml-3 flex justify-between w-full">
                        <span>{{ $option['label'] }}</span>
                        <span class="font-semibold">Rp {{ number_format($option['price']) }}</span>
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg">
            <h4 class="text-lg font-semibold mb-4">Ringkasan</h4>
            @php $subtotal = 0; @endphp
            @foreach(session('cart') as $id => $details)
                @php $subtotal += $details['price'] * $details['quantity']; @endphp
                <div class="flex justify-between items-center mb-2 text-sm">
                    <span>{{ $details['name'] }} x {{ $details['quantity'] }}</span>
                    <span class="font-medium">Rp {{ number_format($details['price'] * $details['quantity']) }}</span>
                </div>
            @endforeach
            <div class="border-t border-gray-200 mt-4 pt-4">
                <div class="flex justify-between text-base">
                    <span class="text-gray-600">Subtotal Produk</span>
                    <span>Rp {{ number_format($subtotal) }}</span>
                </div>
                <p class="text-xs text-gray-500 mt-2">Biaya pengiriman akan ditambahkan setelah Anda memilih kurir.</p>
            </div>
        </div>
    </div>

    <div class="mt-8 text-right">
        <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#FF9898] border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-[#FFAAAA]">
            Lanjutkan ke Pembayaran
        </button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>