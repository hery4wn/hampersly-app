<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 flex items-center space-x-6">
                    @if ($shop->shop_image)
                        <img src="{{ asset('storage/' . $shop->shop_image) }}" alt="{{ $shop->name }}" class="h-28 w-28 object-cover rounded-full border-4 border-white shadow-lg">
                    @else
                        <span class="inline-flex h-28 w-28 items-center justify-center rounded-full bg-gray-500">
                            <span class="text-4xl font-medium leading-none text-white">{{ strtoupper(substr($shop->name, 0, 2)) }}</span>
                        </span>
                    @endif
                    <div class="flex-grow">
                        <h2 class="text-4xl font-bold">{{ $shop->name }}</h2>
                        <p class="mt-2 text-gray-600">{{ $shop->description }}</p>
                        <p class="text-sm text-gray-500 mt-2">Bergabung sejak {{ $shop->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-6">Semua Produk dari {{ $shop->name }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    <div class="group bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300 ease-in-out hover:shadow-2xl">
                        <a href="{{ route('product.show', $product) }}">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="h-64 w-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300"></div>
                            </div>
                        </a>
                        <div class="p-5">
                            <h3 class="font-bold text-xl text-gray-800 truncate mt-1">{{ $product->name }}</h3>
                            <p class="font-extrabold text-2xl text-[#FF9898] mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 py-10">Toko ini belum memiliki produk.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>