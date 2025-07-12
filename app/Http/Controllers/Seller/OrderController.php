<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman manajemen pesanan.
     */
    public function index()
    {
        // Pastikan user memiliki toko
        $shopId = Auth::user()->shop->id;

        // Ambil semua OrderItem yang produknya milik toko ini
        // dan yang status pembayarannya sudah 'paid'
        $orderItems = OrderItem::whereHas('product', function ($query) use ($shopId) {
            $query->where('shop_id', $shopId);
        })->whereHas('order', function ($query) {
            $query->where('payment_status', 'paid');
        })->with(['order.user', 'product'])->latest()->paginate(10);

        return view('seller.orders.index', compact('orderItems'));
    }

    /**
     * Mengupdate status sebuah pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // 1. Validasi: Pastikan status yang dikirim adalah salah satu dari pilihan yang valid.
        $request->validate([
            'status' => ['required', Rule::in(['processing', 'shipped', 'completed', 'cancelled'])],
        ]);

        // 2. Otorisasi (PENTING): Pastikan seller ini berhak mengubah status pesanan ini.
        $shopId = Auth::user()->shop->id;
        $isOwner = $order->items()->whereHas('product', function ($query) use ($shopId) {
            $query->where('shop_id', $shopId);
        })->exists();

        if (!$isOwner) {
            abort(403, 'Aksi tidak diizinkan.'); // Jika tidak berhak, tolak akses.
        }

        // 3. Update Status
        $order->status = $request->status;
        $order->save();

        // 4. Kembali ke halaman sebelumnya dengan pesan sukses.
        return back()->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui.');
    }
}