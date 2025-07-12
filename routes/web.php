<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ReviewController;

// RUTE UNTUK TES DEBUGGING
Route::get('/tes-toko/{shop:slug}', function (App\Models\Shop $shop) {
    return "Berhasil menemukan toko: " . $shop->name;
});
/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/toko/{shop:slug}', [PublicShopController::class, 'show'])->name('shop.show');
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::get('/order/sukses', [CartController::class, 'success'])->name('order.success');


// --- GRUP RUTE UNTUK ADMIN PANEL ---
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/shops', [AdminShopController::class, 'index'])->name('shops.index');
    Route::patch('/shops/{shop}/approve', [AdminShopController::class, 'approve'])->name('shops.approve');
    Route::delete('/shops/{shop}', [AdminShopController::class, 'destroy'])->name('shops.destroy');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');    
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
});

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS USER LOGIN (Middleware Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Rute Dashboard Utama (akan mengarahkan berdasarkan role/status toko)
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // 1. Cek dulu apakah rolenya admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // 2. Jika bukan admin, baru cek apakah rolenya seller
        elseif ($user->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }
        // 3. Jika bukan keduanya, berarti dia adalah customer
        else {
            return redirect()->route('order.history');
        }
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Rute Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Pembuatan Toko (untuk user yang belum jadi seller)
    Route::get('/shop/create', [ShopController::class, 'create'])->name('shop.create');
    Route::post('/shop/store', [ShopController::class, 'store'])->name('shop.store');

    // --- GRUP RUTE UNTUK SELLER ---
    Route::get('/seller/dashboard', [DashboardController::class, 'index'])->name('seller.dashboard');
    Route::get('/seller/shop/edit', [ShopController::class, 'edit'])->name('shop.edit');
    Route::put('/seller/shop', [ShopController::class, 'update'])->name('shop.update');
    // Produk Seller
    Route::get('/seller/products/create', [SellerProductController::class, 'create'])->name('product.create');
    Route::post('/seller/products', [SellerProductController::class, 'store'])->name('product.store');
    Route::get('/seller/products/{product}/edit', [SellerProductController::class, 'edit'])->name('product.edit');
    Route::put('/seller/products/{product}', [SellerProductController::class, 'update'])->name('product.update');
    Route::delete('/seller/products/{product}', [SellerProductController::class, 'destroy'])->name('product.destroy');
    // Pesanan Seller
    Route::get('/seller/pesanan', [SellerOrderController::class, 'index'])->name('seller.orders.index');
    Route::patch('/seller/pesanan/{order}/update-status', [SellerOrderController::class, 'updateStatus'])->name('seller.orders.updateStatus');

    // --- GRUP RUTE UNTUK CUSTOMER ---
    // Keranjang Belanja
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::patch('/keranjang/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'destroy'])->name('cart.remove');
    // Checkout & Pembayaran
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/order/place', [CartController::class, 'placeOrder'])->name('order.place');
    Route::get('/order/payment/{order}', [CartController::class, 'payment'])->name('order.payment');
    // Riwayat Pesanan Customer
    Route::get('/pesanan-saya', [OrderController::class, 'index'])->name('order.history');
    Route::get('/pesanan-saya/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/ulasan/tulis/{product}/{order}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/ulasan', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__ . '/auth.php';
