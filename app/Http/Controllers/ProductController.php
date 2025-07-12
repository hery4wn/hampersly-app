<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // Pastikan produk berasal dari toko yang sudah disetujui
        if (!$product->shop || !$product->shop->is_approved) {
            abort(404);
        }

        // Ambil produk dan semua relasi review beserta user yang menulisnya
        $product->load(['reviews.user']);

        // Ambil 4 produk lain secara acak dari toko yang sama
        $relatedProducts = Product::where('shop_id', $product->shop_id) // Dari toko yang sama
            ->where('id', '!=', $product->id)       // Kecuali produk ini sendiri
            ->inRandomOrder()                      // Ambil secara acak
            ->take(4)                              // Batasi hanya 4 produk
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
