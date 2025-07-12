<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
            {{ __('Edit Profil Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-[#FFAAAA]">
                <div class="p-6 md:p-8 text-gray-900">

                    <form method="POST" action="{{ route('shop.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nama Toko') }}</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $shop->name) }}" required 
                                   class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm">
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Deskripsi Toko') }}</label>
                            <textarea id="description" name="description" 
                                      class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm">{{ old('description', $shop->description) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="shop_image" class="block font-medium text-sm text-gray-700">{{ __('Ganti Foto Profil (Opsional)') }}</label>
                            @if ($shop->shop_image)
                                <img src="{{ asset('storage/' . $shop->shop_image) }}" alt="{{ $shop->name }}" class="h-24 w-24 object-cover rounded-full my-2 border border-gray-200">
                            @endif
                            <input id="shop_image" type="file" name="shop_image"
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:bg-gray-200 file:text-gray-700 file:border-0 file:px-4 file:py-2 file:mr-4">
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-[#FF9898] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#FFAAAA] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF9898] transition ease-in-out duration-150">
                                {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>