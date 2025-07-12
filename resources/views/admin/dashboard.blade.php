<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Total Users</div>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['users'] }}</p>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Detail</a>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a3.002 3.002 0 01-3.71-1.332A3.002 3.002 0 012 11V9a3 3 0 013-3h14a3 3 0 013 3v2a3 3 0 01-3.71 1.332A3.002 3.002 0 0117 16.143m-9.71-1.332a3 3 0 00-3.71-1.332" /></svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Total Shops</div>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['shops'] }}</p>
                        <a href="{{ route('admin.shops.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Detail</a>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <svg class="h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 4h5m-5 4h5m-5-8h5" /></svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Total Products</div>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['products'] }}</p>
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Detail</a>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="h-8 w-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Successful Orders</div>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['orders'] }}</p>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Detail</a>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="h-8 w-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800">Toko Terbaru Menunggu Persetujuan</h3>
                            <div class="mt-4">
                                @forelse($pendingShops as $shop)
                                    <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                                        <div>
                                            <p class="font-semibold">{{ $shop->name }}</p>
                                            <p class="text-sm text-gray-500">oleh {{ $shop->user->name }}</p>
                                        </div>
                                        <a href="{{ route('admin.shops.index') }}" class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full hover:bg-yellow-200">
                                            Lihat & Approve
                                        </a>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Tidak ada toko yang menunggu persetujuan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                         <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
                            <div class="space-y-4">
                                <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    <svg class="h-6 w-6 text-gray-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-2a6 6 0 00-12 0v2" /></svg>
                                    <span class="font-medium">Manajemen User</span>
                                </a>
                                <a href="{{ route('admin.shops.index') }}" class="flex items-center p-3 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                    <svg class="h-6 w-6 text-gray-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 4h5m-5 4h5m-5-8h5" /></svg>
                                    <span class="font-medium">Manajemen Toko</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>