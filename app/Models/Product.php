<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'description',
        'price',
        'stock',
        'image_url',
    ];

    // Sebuah produk dimiliki oleh satu toko
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getRatingAverageAttribute()
    {
        return $this->reviews()->average('rating');
    }

    // Menghitung jumlah review
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}
