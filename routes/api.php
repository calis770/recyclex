<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import controller API
use App\Http\Controllers\API\CustomerOrderController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\Admin\OrderController; // Disarankan: Pisahkan controller admin di namespace Admin

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua rute di sini otomatis menggunakan prefix '/api'.
| Rute dengan middleware 'auth:sanctum' digunakan untuk pelanggan yang login.
| Rute admin sebaiknya dilindungi dengan middleware tambahan seperti 'admin'.
*/

// Rute untuk pelanggan (butuh autentikasi Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Melihat pesanan pribadi
    Route::get('/my-orders', [CustomerOrderController::class, 'index']);

    // Melakukan checkout
    Route::post('/checkout', [CheckoutController::class, 'processCheckout']);
});

// Rute untuk admin (disarankan tambahkan middleware admin untuk proteksi)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Mengubah status satu pesanan
    Route::put('/admin/orders/{order_id}/status', [OrderController::class, 'updateStatus']);

    // Mengubah status banyak pesanan sekaligus
    Route::post('/admin/orders/bulk-status', [OrderController::class, 'bulkUpdateStatus']);
});
