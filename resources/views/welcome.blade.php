<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Hampersly') }} - Temukan Hampers Unik Penuh Makna</title>

<link rel="icon" type="image/png" href="{{ asset('images/favicon.ico') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            @include('layouts.navigation')

            <main>
                <section class="relative h-[60vh] flex items-center justify-center text-center text-white overflow-hidden">
                    <div class="absolute inset-0">
                        <img src="{{ asset($banner) }}" 
                             alt="Banner Hampers" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50"></div> </div>
                    <div class="relative z-10 px-4">
                        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight">Kebahagiaan dalam Kotak</h1>
                        <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-200">
                            Pilih dari ratusan hampers yang dikurasi dengan penuh cinta oleh para penjual terbaik di seluruh Indonesia.
                        </p>
                        <a href="#produk-terbaru" class="mt-8 inline-block px-8 py-3 bg-[#FF9898] text-white font-bold rounded-full shadow-lg hover:bg-[#FFAAAA] transition-transform hover:scale-105">
                            Belanja Sekarang
                        </a>
                    </div>
                </section>

                <section class="py-16 bg-white">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                            <div>
                                <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-[#FFE99A] text-[#A16262]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <h3 class="mt-4 text-xl font-bold">Kurasi Terbaik</h3>
                                <p class="mt-2 text-gray-600">Setiap produk dipilih dengan standar kualitas tertinggi untuk momen spesial Anda.</p>
                            </div>
                            <div>
                                <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-[#FFE99A] text-[#A16262]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.228 19.272a1 1 0 01-1.414-1.414l5.656-5.656a1 1 0 011.414 0l4.243 4.243a1 1 0 001.414-1.414l-4.243-4.243-1.414-1.414a1 1 0 010-1.414l5.656-5.656a1 1 0 011.414 1.414L10.414 12l5.657 5.657a1 1 0 010 1.414l-5.657 5.657a1 1 0 01-1.414 0L4.228 19.272z" /></svg>
                                </div>
                                <h3 class="mt-4 text-xl font-bold">Dukung UKM Lokal</h3>
                                <p class="mt-2 text-gray-600">Berbelanja di sini berarti Anda turut mendukung pertumbuhan usaha kecil dan menengah.</p>
                            </div>
                            <div>
                                <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-[#FFE99A] text-[#A16262]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l1.414 1.414a1 1 0 01.293.707V16m-7-7h2.5a1 1 0 011 1v6a1 1 0 01-1 1H9a1 1 0 01-1-1v-6a1 1 0 011-1z" /></svg>
                                </div>
                                <h3 class="mt-4 text-xl font-bold">Pengiriman Aman</h3>
                                <p class="mt-2 text-gray-600">Kami memastikan setiap hampers dikemas dengan aman dan tiba di tujuan dengan sempurna.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <div id="produk-terbaru" class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    @if (request('search'))
                        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">
                            Hasil pencarian untuk: <span class="text-[#FF9898]">"{{ request('search') }}"</span>
                        </h2>
                    @else
                        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Produk Terbaru Kami</h2>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @forelse ($products as $product)
                            <div class="group bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300 ease-in-out hover:shadow-2xl">
                                <a href="{{ route('product.show', $product) }}">
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="h-64 w-full object-cover">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                            <svg class="h-12 w-12 text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </div>
                                    </div>
                                </a>
                                <div class="p-5">
                                    @if ($product->shop)
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">
                                        <a href="{{ route('shop.show', $product->shop->slug) }}" class="hover:text-[#FF9898] transition-colors">
                                            {{ $product->shop->name }}
                                        </a>
                                    </p>
                                    @endif
                                    <h3 class="font-bold text-xl text-gray-800 truncate mt-1">{{ $product->name }}</h3>
                                    <p class="font-extrabold text-2xl text-[#FF9898] mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <a href="{{ route('product.show', $product) }}" class="mt-4 block w-full text-center px-4 py-2 bg-[#FFE99A] text-[#A16262] font-semibold rounded-lg border border-[#FFD586] hover:bg-[#FFD586] hover:text-white transition-all duration-300">Lihat Detail</a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <h3 class="mt-2 text-lg font-semibold text-gray-900">Produk Tidak Ditemukan</h3>
                                <p class="mt-1 text-sm text-gray-500">Maaf, kami tidak dapat menemukan produk yang cocok.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                </div>
            </main>
            
            <footer class="bg-white border-t">
                <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-gray-500">
                    <p>&copy; {{ date('Y') }} Hampersly. Semua Hak Cipta Dilindungi.</p>
                </div>
            </footer>
        </div>
    </body>
</html>