<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('user')->latest()->paginate(15);
        return view('admin.shops.index', compact('shops'));
    }

    public function approve(Shop $shop)
    {
        $shop->is_approved = true;
        $shop->save();
        return back()->with('success', 'Toko berhasil disetujui.');
    }

    // --- TAMBAHKAN FUNGSI BARU DI BAWAH INI ---
    public function destroy(Shop $shop)
    {
        // Ambil data user pemilik toko sebelum toko dihapus
        $user = $shop->user;

        // 1. Hapus gambar profil toko dari storage jika ada
        if ($shop->shop_image) {
            Storage::disk('public')->delete($shop->shop_image);
        }

        // 2. Hapus data toko dari database
        // (Semua produk terkait akan ikut terhapus otomatis karena 'onDelete cascade')
        $shop->delete();

        // 3. Ubah kembali role pemiliknya menjadi 'customer'
        if ($user) {
            $user->role = 'customer';
            $user->save();
        }

        return back()->with('success', 'Toko dan semua produknya berhasil dihapus.');
    }
}