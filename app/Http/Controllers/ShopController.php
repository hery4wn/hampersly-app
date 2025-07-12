<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    // ... (fungsi create() dan store() sudah ada di sini) ...
    public function create()
    {
        return view('shops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:shops',
            'description' => 'required|string|min:10',
        ]);
        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($request->name, '-');
        Shop::create($validated);

        $user = Auth::user();
        $user->role = 'seller'; // Ubah role menjadi 'seller'
        $user->save(); // Simpan perubahan ke database

        return redirect()->route('dashboard')->with('success', 'Selamat! Toko Anda berhasil dibuat.');
    }

    // --- TAMBAHKAN FUNGSI BARU DI BAWAH INI ---

    public function edit()
    {
        // Ambil data toko dari user yang sedang login
        $shop = Auth::user()->shop;
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        // Ambil toko milik user yang sedang login
        $shop = $request->user()->shop;

        // Validasi data
        $validated = $request->validate([
            // Pastikan nama unik, tapi abaikan nama toko ini sendiri
            'name' => ['required', 'string', 'max:255', Rule::unique('shops')->ignore($shop->id)],
            'description' => ['required', 'string', 'min:10'],
            'shop_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $validated['slug'] = Str::slug($request->name, '-');

        // Cek jika ada file gambar baru
        if ($request->hasFile('shop_image')) {
            // Hapus gambar lama jika ada
            if ($shop->shop_image) {
                Storage::disk('public')->delete($shop->shop_image);
            }
            // Simpan gambar baru
            $path = $request->file('shop_image')->store('shops', 'public');
            $validated['shop_image'] = $path;
        }

        // Update data toko
        $shop->update($validated);

        return redirect()->route('seller.dashboard')->with('success', 'Profil toko berhasil diperbarui!');
    }
}
