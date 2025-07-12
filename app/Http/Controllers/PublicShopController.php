<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class PublicShopController extends Controller
{
    public function show(Shop $shop)
    {
        // Ambil produk yang hanya milik toko ini, urutkan dari terbaru, dan paginasi
        $products = $shop->products()->latest()->paginate(12);

        // Tampilkan view dan kirim data toko beserta produknya
        return view('shops.show', compact('shop', 'products'));
    }
}