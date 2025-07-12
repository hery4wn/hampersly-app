<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
            {{ __('Tulis Ulasan Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="flex items-start space-x-4 mb-6 border-b pb-6">
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="h-24 w-24 object-cover rounded-md">
                        <div>
                            <p class="text-sm text-gray-500">Memberi ulasan untuk:</p>
                            <h3 class="text-xl font-bold">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600">Dibeli dari pesanan #{{ $order->id }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Rating Anda</label>
                            <div class="flex flex-row-reverse justify-end items-center" x-data="{ rating: 0 }">
                                <input type="radio" id="star5" name="rating" value="5" class="hidden" x-model="rating" /><label for="star5" class="text-3xl cursor-pointer" :class="{'text-yellow-400': rating >= 5, 'text-gray-300': rating < 5}">★</label>
                                <input type="radio" id="star4" name="rating" value="4" class="hidden" x-model="rating" /><label for="star4" class="text-3xl cursor-pointer" :class="{'text-yellow-400': rating >= 4, 'text-gray-300': rating < 4}">★</label>
                                <input type="radio" id="star3" name="rating" value="3" class="hidden" x-model="rating" /><label for="star3" class="text-3xl cursor-pointer" :class="{'text-yellow-400': rating >= 3, 'text-gray-300': rating < 3}">★</label>
                                <input type="radio" id="star2" name="rating" value="2" class="hidden" x-model="rating" /><label for="star2" class="text-3xl cursor-pointer" :class="{'text-yellow-400': rating >= 2, 'text-gray-300': rating < 2}">★</label>
                                <input type="radio" id="star1" name="rating" value="1" class="hidden" x-model="rating" required /><label for="star1" class="text-3xl cursor-pointer" :class="{'text-yellow-400': rating >= 1, 'text-gray-300': rating < 1}">★</label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('rating')" />
                        </div>

                        <div class="mt-4">
                            <label for="comment" class="block font-medium text-sm text-gray-700">Ulasan Anda (Opsional)</label>
                            <textarea id="comment" name="comment" rows="4" class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm">{{ old('comment') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('comment')" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-[#FF9898] border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-[#FFAAAA]">
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>