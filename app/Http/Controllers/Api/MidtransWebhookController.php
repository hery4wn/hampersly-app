<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Validasi signature key untuk keamanan
        $signatureKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . config('midtrans.server_key'));
        if ($signatureKey != $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari pesanan berdasarkan order_id
        $order = Order::where('order_number', $request->order_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Gunakan transaction agar aman
        DB::transaction(function () use ($request, $order) {
            $status = $request->transaction_status;
            $fraudStatus = $request->fraud_status;

            if ($status == 'capture') {
                if ($fraudStatus == 'accept') {
                    // Pembayaran dengan kartu kredit berhasil
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                }
            } else if ($status == 'settlement') {
                // Pembayaran dengan metode lain (GoPay, QRIS, dll) berhasil
                $order->payment_status = 'paid';
                $order->status = 'processing';
            } else if ($status == 'pending') {
                // Menunggu pembayaran
                $order->payment_status = 'pending';
            } else if ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                // Pembayaran gagal atau dibatalkan
                $order->payment_status = 'failed';
                $order->status = 'cancelled';
            }

            if (isset($request->payment_type)) {
                $order->payment_method = $request->payment_type;
            }

            $order->save();

            // Jika pembayaran berhasil, kurangi stok produk
            if ($order->payment_status == 'paid') {
                foreach ($order->items as $item) {
                    Product::find($item->product_id)->decrement('stock', $item->quantity);
                }
            }
        });

        return response()->json(['status' => 'ok']);
    }
}
