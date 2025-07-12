<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
            {{ __('Dashboard Toko Anda') }}
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

            <div class="mb-8">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ringkasan Kinerja Toko</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#FFE99A] p-6 rounded-lg shadow-sm border border-[#FFD586]">
                        <h4 class="text-sm font-medium text-gray-600">Total Pendapatan</h4>
                        <p class="mt-1 text-3xl font-bold text-[#FF9898]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-[#FFE99A] p-6 rounded-lg shadow-sm border border-[#FFD586]">
                        <h4 class="text-sm font-medium text-gray-600">Produk Terjual</h4>
                        <p class="mt-1 text-3xl font-bold text-[#FF9898]">{{ $productsSoldCount }}</p>
                    </div>
                    <div class="bg-[#FFE99A] p-6 rounded-lg shadow-sm border border-[#FFD586]">
                        <h4 class="text-sm font-medium text-gray-600">Pesanan Selesai</h4>
                        <p class="mt-1 text-3xl font-bold text-[#FF9898]">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="mb-6 border-b border-gray-200">
                                <div class="flex space-x-6">
                                    <a href="{{ route('seller.dashboard') }}" class="py-3 px-1 border-b-2 border-[#FF9898] text-sm font-medium text-[#FF9898]">Produk Saya</a>
                                    <a href="{{ route('seller.orders.index') }}" class="py-3 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Pesanan Masuk</a>
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Produk</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($products as $product)
                                            <tr>
                                                <td class="px-6 py-4"><img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded"></td>
                                                <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                                                <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4">{{ $product->stock }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex items-center space-x-4">
                                                        <a href="{{ route('product.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                        <form action="{{ route('product.destroy', $product) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Anda belum memiliki produk.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">{{ $products->links() }}</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
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