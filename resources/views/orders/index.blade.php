<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

    {{-- TAMBAHKAN BLOK KONDISIONAL INI --}}
    @if (!Auth::user()->shop)
        <div class="bg-[#FFF8E1] border-l-4 border-[#FFD586] p-6 rounded-lg mb-8 text-center shadow">
            <h4 class="text-xl font-bold text-gray-800">Ingin Mulai Berjualan?</h4>
            <p class="text-gray-600 mt-2">Buka toko Anda sendiri di Hampersly dan jangkau ribuan customer. Gratis!</p>
            <a href="{{ route('shop.create') }}" class="mt-4 inline-block px-6 py-2 bg-[#FF9898] text-white font-semibold rounded-lg shadow-md hover:bg-[#FFAAAA] transition-colors">
                + Buat Toko Sekarang
            </a>
        </div>
    @endif

    <h3 class="text-2xl font-bold mb-6">Daftar Pesanan</h3>

    <div class="space-y-6">


                    
                    <div class="space-y-6">
                        @forelse ($orders as $order)
                            <div class="border rounded-lg p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div>
                                    <div class="font-bold text-lg">Pesanan #{{ $order->id }}</div>
                                    <div class="text-sm text-gray-500">Dipesan pada: {{ $order->created_at->format('d F Y, H:i') }}</div>
                                    <div class="text-lg font-bold text-[#FF9898] mt-2">Rp {{ number_format($order->total_amount) }}</div>
                                </div>
                                <div class="mt-4 sm:mt-0 text-right flex flex-col items-end">
    @if ($order->payment_status == 'unpaid' && $order->status != 'cancelled')
        {{-- Jika belum dibayar dan tidak dibatalkan, tampilkan tombol bayar --}}
        <a href="{{ route('order.payment', $order) }}" class="inline-block px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition-colors">
            Bayar Sekarang
        </a>
        <div class="text-xs text-gray-500 mt-1">Menunggu Pembayaran</div>
    @else
        {{-- Jika sudah dibayar atau status lain, tampilkan badge status --}}
        <span @class([
            'px-3 py-1 text-sm font-semibold rounded-full',
            'bg-yellow-100 text-yellow-800' => $order->status == 'pending',
            'bg-blue-100 text-blue-800' => $order->status == 'processing',
            'bg-purple-100 text-purple-800' => $order->status == 'shipped',
            'bg-green-100 text-green-800' => $order->status == 'completed',
            'bg-red-100 text-red-800' => $order->status == 'cancelled',
        ])>
            @if($order->status == 'shipped')
                Dikirim
            @else
                {{ ucfirst($order->status) }}
            @endif
        </span>
        <div class="text-xs text-gray-600 mt-2">
            Pembayaran: {{ ucfirst($order->payment_status) }}
        </div>
    @endif

    <a href="{{ route('order.show', $order) }}" class="mt-2 inline-block text-sm text-blue-600 hover:underline">Lihat Detail</a>
</div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-500">Anda belum memiliki riwayat pesanan.</p>
                                <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:underline font-semibold">Mulai Belanja</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>