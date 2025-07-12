<?php

namespace App\Services;

use App\Models\Order; // <-- Tambahkan ini
use Midtrans\Config;
use Midtrans\Snap; // <-- Tambahkan ini

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Membuat Snap Token untuk sebuah pesanan.
     *
     * @param \App\Models\Order $order
     * @return string
     */
    public function getSnapToken(Order $order)
    {
        // Buat array untuk item_details dari produk-produk di keranjang
        $item_details = $order->items->map(function ($item) {
            return [
                'id' => 'PROD-' . $item->product_id, // Beri prefix agar unik
                'price' => $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        })->toArray();

        // --- INI BAGIAN PENTINGNYA ---
        // Tambahkan biaya pengiriman sebagai satu item terpisah ke dalam array
        $item_details[] = [
            'id' => 'SHIPPING_COST',
            'price' => $order->shipping_cost,
            'quantity' => 1,
            'name' => 'Biaya Pengiriman (' . $order->shipping_courier . ')',
        ];

        // Siapkan parameter lengkap untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total_amount, // total_amount di DB kita sudah benar (produk + ongkir)
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'item_details' => $item_details, // Gunakan item_details yang sekarang sudah lengkap dengan ongkir
        ];

        return Snap::getSnapToken($params);
    }
}
