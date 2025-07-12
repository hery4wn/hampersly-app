<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Mulai dengan query dasar
        $productsQuery = Product::with('shop')->whereHas('shop', function ($query) {
            $query->where('is_approved', true);
        });

        // 2. Tambahkan filter pencarian JIKA ada input 'search'
        if (request('search')) {
            $searchTerm = request('search');
            $productsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('shop', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // 3. Siapkan data tambahan (banner)
        $banners = [
            'images/banner-1.jpeg',
            'images/banner-2.jpeg',
            'images/banner-3.jpeg',
            'images/banner-4.jpeg',
            'images/banner-5.jpeg',
        ];
        // Pilih satu gambar secara acak, dengan pengecekan jika array tidak kosong
        $randomBanner = !empty($banners) ? $banners[array_rand($banners)] : 'images/banner-1.jpeg'; // Default banner

        // 4. EKSEKUSI query di akhir dengan paginasi dan urutan
        $products = $productsQuery->latest()->paginate(12)->withQueryString();

        // 5. Kirim SEMUA data ke view dalam satu kali return
        return view('welcome', [
            'products' => $products,
            'banner' => $randomBanner
        ]);
    }
}
