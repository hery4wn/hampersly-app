<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi gambar
        ]);

        // Dapatkan ID toko milik seller yang login
        $shopId = Auth::user()->shop->id;
        $validated['shop_id'] = $shopId;

        // Proses upload gambar
        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/products dan dapatkan path-nya
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = $path;
        }

        Product::create($validated);

        return redirect()->route('seller.dashboard')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit(Product $product)
{
    // Tampilkan view form edit dengan data produk yang akan diedit
    return view('seller.products.edit', [
        'product' => $product
    ]);
}

public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // image sekarang opsional
    ]);

    // Cek jika ada file gambar baru yang di-upload
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }
        // Simpan gambar baru dan update path-nya
        $path = $request->file('image')->store('products', 'public');
        $validated['image_url'] = $path;
    }

    // Update data produk di database
    $product->update($validated);

    return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil diperbarui!');
}

public function destroy(Product $product)
{
    // Hapus gambar dari storage jika ada
    if ($product->image_url) {
        Storage::disk('public')->delete($product->image_url);
    }

    // Hapus data produk dari database
    $product->delete();

    return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil dihapus.');
}


}
