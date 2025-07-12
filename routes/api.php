<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MidtransWebhookController; // <-- Pastikan ini ditambahkan

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Rute Contoh Bawaan Laravel (Kita nonaktifkan dengan komentar)
|--------------------------------------------------------------------------
*/
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


/*
|--------------------------------------------------------------------------
| Rute API untuk Aplikasi Hampersly
|--------------------------------------------------------------------------
*/
Route::post('/midtrans-webhook', [MidtransWebhookController::class, 'handle']);