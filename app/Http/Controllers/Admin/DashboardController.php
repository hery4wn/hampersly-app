<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'shops' => Shop::count(),
            'products' => Product::count(),
            'orders' => Order::where('payment_status', 'paid')->count(),
        ];

        // Ambil 5 toko terbaru yang belum disetujui
        $pendingShops = Shop::where('is_approved', false)->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pendingShops'));
    }
}