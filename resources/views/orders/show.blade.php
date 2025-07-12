<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
                Detail Pesanan #{{ $order->id }}
            </h2>
            <a href="{{ route('order.history') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
    </svg>
    Kembali
</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center border-b pb-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                            <p class="font-bold text-gray-800">#{{ $order->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                            <p class="font-bold text-gray-800">{{ $order->created_at->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Pembayaran</p>
                            <p class="font-bold text-gray-800">Rp {{ number_format($order->total_amount) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span @class([
                                'px-3 py-1 text-sm font-semibold rounded-full',
                                'bg-yellow-100 text-yellow-800' => $order->status == 'pending',
                                'bg-blue-100 text-blue-800' => $order->status == 'processing',
                                'bg-purple-100 text-purple-800' => $order->status == 'shipped',
                                'bg-green-100 text-green-800' => $order->status == 'completed',
                                'bg-red-100 text-red-800' => $order->status == 'cancelled',
                            ])>
                                @if($order->status == 'shipped') Dikirim @else {{ ucfirst($order->status) }} @endif
                            </span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Rincian Barang</h3>
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="flex items-center space-x-4 p-2 border rounded-md">
                                    <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="h-20 w-20 object-cover rounded-md">
                                    <div class="flex-grow">
                                        <p class="font-bold">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600">Jumlah: {{ $item->quantity }}</p>
                                    </div>
<div class="text-right">
    <p class="font-semibold">Rp {{ number_format($item->price * $item->quantity) }}</p>
    <p class="text-sm text-gray-500 mb-2">(@ Rp {{ number_format($item->price) }})</p>

    @if($order->status == 'completed' && !in_array($item->product_id, $reviewedProductIds))
    <a href="{{ route('reviews.create', ['product' => $item->product_id, 'order' => $order->id]) }}" class="text-xs font-semibold text-blue-600 border border-blue-600 rounded-full px-3 py-1 hover:bg-blue-600 hover:text-white transition-colors">>
        Tulis Ulasan
    </a>
@endif
</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Alamat Pengiriman</h3>
                            <address class="not-italic text-gray-600">
                                {{ $order->shipping_address }}
                            </address>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Info Pembayaran</h3>
                            <p class="text-gray-600">Metode: {{ $order->payment_method }}</p>
                            <p class="text-gray-600">Status: {{ ucfirst($order->payment_status) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>