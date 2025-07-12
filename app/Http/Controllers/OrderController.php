<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan milik user yang sedang login.
     */
    public function index()
    {
        // Ambil pesanan milik user yang login, urutkan dari yang terbaru,
        // lalu bagi per halaman (10 pesanan per halaman).
        $orders = Auth::user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

// Ganti fungsi show() di OrderController
public function show(Order $order)
{
    if (Auth::id() !== $order->user_id) { abort(403); }

    // Ambil ID produk yang sudah direview dalam order ini
    $reviewedProductIds = $order->reviews()->pluck('product_id')->toArray();

    return view('orders.show', [
        'order' => $order->load('items.product'),
        'reviewedProductIds' => $reviewedProductIds // Kirim data ini ke view
    ]);
}
}
