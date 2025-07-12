<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
            {{ __('Manajemen Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="mb-6 border-b border-gray-200">
                                <div class="flex space-x-6">
                                    <a href="{{ route('seller.dashboard') }}" class="py-3 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        Produk Saya
                                    </a>
                                    <a href="{{ route('seller.orders.index') }}" class="py-3 px-1 border-b-2 border-[#FF9898] text-sm font-medium text-[#FF9898]">
                                        Pesanan Masuk
                                    </a>
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Pesanan Masuk</h3>
                            <div class="space-y-6">
                                @forelse ($orderItems as $item)
                                    <div class="border rounded-lg p-4 shadow-sm">
                                        <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b pb-3 mb-3">
                                            <div>
                                                <div class="font-bold">Pesanan #{{ $item->order->id }}</div>
                                                <div class="text-sm text-gray-500">Tanggal: {{ $item->order->created_at->format('d F Y') }}</div>
                                            </div>
                                            <form action="{{ route('seller.orders.updateStatus', $item->order->id) }}" method="POST" class="flex items-center space-x-2 mt-3 sm:mt-0">
                                                @csrf
                                                @method('PATCH')
                                                <label for="status-{{ $item->order->id }}" class="text-sm font-medium">Status:</label>
                                                <select name="status" id="status-{{ $item->order->id }}" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="processing" @selected($item->order->status == 'processing')>Diproses</option>
                                                    <option value="shipped" @selected($item->order->status == 'shipped')>Dikirim</option>
                                                    <option value="completed" @selected($item->order->status == 'completed')>Selesai</option>
                                                    <option value="cancelled" @selected($item->order->status == 'cancelled')>Dibatalkan</option>
                                                </select>
                                                <button type="submit" class="px-3 py-1.5 bg-[#FF9898] text-white text-xs font-semibold rounded-md hover:bg-[#FFAAAA]">Update</button>
                                            </form>
                                        </div>

                                        <div class="flex items-start space-x-4 pt-3">
                                            <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="h-20 w-20 object-cover rounded">
                                            <div class="flex-grow">
                                                <div class="font-bold text-lg">{{ $item->product->name }}</div>
                                                <div class="text-sm text-gray-600">Jumlah: {{ $item->quantity }}</div>
                                                <div class="text-sm text-gray-600">Harga Satuan: Rp {{ number_format($item->price) }}</div>
                                            </div>
                                        </div>
                                        
<div class="mt-4 border-t pt-3">
    <div class="text-sm font-semibold mb-1">Info Pengiriman</div>
    <div class="text-sm text-gray-700">
        <span class="font-medium">Penerima:</span> {{ $item->order->user->name }}
    </div>
    <div class="text-sm text-gray-700">
        <span class="font-medium">Kurir:</span> {{ $item->order->shipping_courier }}
    </div>
    <div class="text-sm text-gray-700 mt-1">
        <span class="font-medium">Alamat:</span>
        <address class="not-italic inline">{{ $item->order->shipping_address }}</address>
    </div>
</div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-10">Belum ada pesanan yang masuk.</p>
                                @endforelse
                            </div>
                            <div class="mt-8">{{ $orderItems->links() }}</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            @php $shop = Auth::user()->shop; @endphp
                            <div class="flex items-center space-x-4 mb-4">
                                @if ($shop->shop_image)
                                    <img src="{{ asset('storage/' . $shop->shop_image) }}" alt="{{ $shop->name }}" class="h-16 w-16 object-cover rounded-full">
                                @else
                                    <span class="h-16 w-16 rounded-full bg-[#FFE99A] flex items-center justify-center"><span class="text-2xl font-medium text-[#A16262]">{{ strtoupper(substr($shop->name, 0, 2)) }}</span></span>
                                @endif
                                <div>
                                    <h4 class="text-lg font-bold">{{ $shop->name }}</h4>
                                    @if ($shop->is_approved)
    <p class="text-sm text-gray-500">Status: 
        <span class="font-semibold text-green-600">Aktif</span>
    </p>
@else
    <p class="text-sm text-gray-500">Status: 
        <span class="font-semibold text-yellow-600">Menunggu Persetujuan</span>
    </p>
@endif
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 border-t pt-4">{{ $shop->description }}</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold mb-4">Aksi Cepat</h4>
                            <div class="space-y-3">
                                <a href="{{ route('product.create') }}" class="w-full text-center inline-block px-4 py-2 bg-[#FF9898] text-white font-semibold rounded-lg hover:bg-[#FFAAAA] transition-colors">Tambah Produk Baru</a>
                                <a href="{{ route('shop.edit') }}" class="w-full text-center inline-block px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-colors">Edit Profil Toko</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>