<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Menampilkan form untuk menulis review
    public function create(Product $product, Order $order)
    {
        // Otorisasi: Pastikan order ini milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        // Pastikan order sudah selesai
        if ($order->status !== 'completed') {
            return back()->with('error', 'Anda hanya bisa mereview produk dari pesanan yang sudah selesai.');
        }
        // Pastikan user belum mereview produk ini dari order ini
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->where('order_id', $order->id)
                                ->exists();
        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini dari pesanan tersebut.');
        }

        return view('reviews.create', compact('product', 'order'));
    }

    // Menyimpan review baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Lakukan lagi pengecekan otorisasi & duplikat untuk keamanan
        $order = Order::find($request->order_id);
        if ($order->user_id !== Auth::id() || $order->status !== 'completed') {
            abort(403);
        }
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $request->product_id)
                                ->where('order_id', $request->order_id)
                                ->exists();
        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        // Simpan review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('order.show', $order)->with('success', 'Terima kasih atas ulasan Anda!');
    }
}