<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pesanan dengan pembelinya (user dengan role 'customer')
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 14, 2); // Total harga pesanan
            $table->string('status')->default('pending'); // Contoh: pending, processing, shipped, completed, cancelled
            $table->string('shipping_address');
            $table->string('payment_method');
            $table->string('payment_status')->default('unpaid'); // Contoh: unpaid, paid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
