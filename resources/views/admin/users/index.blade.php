<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen User') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
@if (session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
        {{ session('error') }}
    </div>
@endif

<table class="min-w-full ...">                    
<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Shop Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th> </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($users as $user)
        <tr>
            <td class="px-6 py-4">{{ $user->name }}</td>
            <td class="px-6 py-4">{{ $user->email }}</td>
            <td class="px-6 py-4">
                <span @class([
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    'bg-blue-100 text-blue-800' => $user->role == 'customer',
                    'bg-green-100 text-green-800' => $user->role == 'seller',
                    'bg-red-100 text-red-800' => $user->role == 'admin',
                ])>
                    {{ $user->role }}
                </span>
            </td>
            <td class="px-6 py-4">{{ $user->shop->name ?? 'N/A' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                @if(Auth::id() !== $user->id)
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                onclick="return confirm('PERINGATAN: Menghapus user ini juga akan menghapus toko dan semua produknya secara permanen. Anda yakin?')">
                            Hapus
                        </button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>