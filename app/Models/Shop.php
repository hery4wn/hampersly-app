<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'address',
        'phone_number',
        'shop_image',
    ];

    // Sebuah toko dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sebuah toko memiliki banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
