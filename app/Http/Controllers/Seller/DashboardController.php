<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN INI

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek jika user tidak punya toko sama sekali
        if (!$user->shop) {
            // Jika dia admin, arahkan ke dashboard admin
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            // Jika dia customer, arahkan ke halaman pembuatan toko
            return redirect()->route('shop.create');
        }

        // Ambil data toko
        $shop = $user->shop;

        // Inisialisasi variabel statistik
        $totalRevenue = 0;
        $productsSoldCount = 0;
        $totalOrders = 0;

        // HANYA hitung statistik jika toko sudah disetujui
        if ($shop->is_approved) {
            $productIds = $shop->products()->pluck('id');
            $completedItemsQuery = \App\Models\OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', function ($query) {
                    $query->where('status', 'completed');
                });
            $totalRevenue = (clone $completedItemsQuery)->sum(DB::raw('price * quantity'));
            $productsSoldCount = (clone $completedItemsQuery)->sum('quantity');
            $totalOrders = (clone $completedItemsQuery)->distinct('order_id')->count('order_id');
        }

        // Ambil produk dengan paginasi
        $products = $shop->products()->latest()->paginate(10);

        // Kirim semua data ke view
        return view('seller.dashboard', [
            'shop' => $shop,
            'products' => $products,
            'totalRevenue' => $totalRevenue,
            'productsSoldCount' => $productsSoldCount,
            'totalOrders' => $totalOrders,
        ]);
    }
}
