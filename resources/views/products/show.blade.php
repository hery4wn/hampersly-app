<x-app-layout>
    <div class="bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                    
                    <div>
                        <div class="w-full aspect-square relative">
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-xl">
                        </div>
                    </div>

                    <div class="flex flex-col h-full">
                        <div>
                            @if ($product->shop)
                                <a href="{{ route('shop.show', $product->shop->slug) }}" class="text-sm font-semibold text-gray-500 hover:text-[#FF9898] transition-colors">
                                    {{ $product->shop->name }}
                                </a>
                            @endif
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-1">{{ $product->name }}</h1>
                            
                            <div class="flex items-center mt-2">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg @class(['h-5 w-5', 'text-yellow-400' => $i <= round($product->rating_average), 'text-gray-300' => $i > round($product->rating_average)]) xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="ml-2 text-sm text-gray-500">{{ $product->review_count }} ulasan</p>
                            </div>
                            
                            <p class="text-3xl font-extrabold text-[#FF9898] my-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            
                            <div class="text-sm text-gray-600 mb-6">
                                @if($product->stock > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Stok Tersedia: {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Stok Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-auto pt-6 border-t">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center space-x-4 mb-4">
                                    <label for="quantity" class="font-semibold text-gray-700">Jumlah:</label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                           class="w-20 text-center border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm"
                                           {{ $product->stock == 0 ? 'disabled' : '' }}>
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-[#FF9898] border border-transparent rounded-md font-semibold text-lg text-white uppercase tracking-widest hover:bg-[#FFAAAA] focus:outline-none disabled:opacity-50"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                                    {{ $product->stock > 0 ? '+ Tambah ke Keranjang' : 'Stok Habis' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-12">
                    <div class="border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900 pb-4">Detail Produk</h2>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mt-8">
                        <div class="lg:col-span-2 prose max-w-none text-gray-600">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        <div class="lg:col-span-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Ulasan Pelanggan</h3>
                            <div class="space-y-6">
                                @forelse ($product->reviews as $review)
                                    <div class="flex space-x-4">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-gray-600 font-bold">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center">
                                                <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                                                <div class="flex items-center ml-2">@for ($i = 1; $i <= $review->rating; $i++)<svg class="h-4 w-4 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>@endfor</div>
                                            </div>
                                            <p class="mt-1 text-gray-600 text-sm">{{ $review->comment }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">Belum ada ulasan untuk produk ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($relatedProducts->isNotEmpty())
            @endif
    </div>
</x-app-layout>