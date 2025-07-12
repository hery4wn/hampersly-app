<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address',
        'payment_method',
        'payment_status',
        'shipping_courier',
        'shipping_cost',    
    ];

      // Sebuah pesanan dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sebuah pesanan memiliki banyak item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews() 
    { 
        return $this->hasMany(Review::class); 
    }

}
