<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#A16262] leading-tight">
            {{ __('Buat Toko Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-[#FFAAAA]">
                <div class="p-6 md:p-8 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Lengkapi Informasi Toko
                    </h3>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('shop.store') }}">
                        @csrf

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nama Toko') }}</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm">
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Deskripsi Singkat Toko Anda') }}</label>
                            <textarea id="description" name="description" 
                                      class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-[#FF9898] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#FFAAAA] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF9898] transition ease-in-out duration-150">
                                {{ __('Buat Toko') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>