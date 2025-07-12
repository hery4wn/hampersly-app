<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Menggunakan View Composer untuk mengirim data ke view navigasi
        View::composer('layouts.navigation', function ($view) {
            $cart = session()->get('cart', []);
            $cartCount = count($cart); // Hitung jumlah jenis item di keranjang

            $view->with('cartCount', $cartCount); // Kirim data cartCount ke view
        });
    }
}
