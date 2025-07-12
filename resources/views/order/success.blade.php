<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <svg class="h-20 w-20 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-3xl font-bold text-gray-800">Terima Kasih!</h2>
                <p class="text-gray-600 mt-2">Pesanan Anda telah berhasil kami terima.</p>
                <p class="text-gray-600">Kami akan segera memproses pesanan Anda.</p>
                <div class="mt-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-[#FF9898] border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-[#FFAAAA]">
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>