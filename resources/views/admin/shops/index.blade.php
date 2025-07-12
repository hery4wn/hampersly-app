<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Toko</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Toko</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($shops as $shop)
                            <tr>
                                <td class="px-6 py-4">{{ $shop->name }}</td>
                                <td class="px-6 py-4">{{ $shop->user->name }}</td>
                                <td class="px-6 py-4">
                                    @if($shop->is_approved)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @endif
                                </td>
<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    <div class="flex items-center space-x-4">
        @if(!$shop->is_approved)
            <form action="{{ route('admin.shops.approve', $shop) }}" method="POST" class="inline-block">
                @csrf
                @method('PATCH')
                <button type="submit" class="text-indigo-600 hover:text-indigo-900">Approve</button>
            </form>
        @endif

        <form action="{{ route('admin.shops.destroy', $shop) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Anda yakin ingin menghapus toko ini? Semua produk di dalamnya juga akan terhapus secara permanen.')">
                Hapus
            </button>
        </form>
    </div>
</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $shops->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>