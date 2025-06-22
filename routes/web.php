<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CoinsController;
use App\Http\Controllers\ExchangeItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\HomeController; // Pastikan ini diimpor
use App\Http\Controllers\CustomerController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

// Public routes - dapat diakses tanpa login
Route::get('/landingpage', function () {
    return view('landingpage');
})->name('landingpage');


// Homepage public routes - untuk menampilkan produk
// Kita bisa mengarahkan '/' dan '/homepage' ke HomeController@index
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');

// Tambahkan Route::get('/products') di sini untuk diakses publik
// Ini akan menjadi daftar semua produk untuk customer, jadi tidak perlu middleware admin
Route::get('/products', [HomeController::class, 'index'])->name('products.customer.index'); // <-- UBAH DI SINI

Route::get('/search', [HomeController::class, 'search'])->name('products.search');
Route::get('/category/{category}', [HomeController::class, 'filterByCategory'])->name('products.category');

// Product detail routes - public access
Route::get('/product/{id}', [ProductController::class, 'showProductCust'])->name('productdetail');

// Auth routes - untuk login/signup
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showsignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/carts/create', [CartController::class, 'create'])->name('carts.create.');
Route::post('add/cust/carts', [CartController::class, 'store'])->name('carts.store');
// Protected routes - memerlukan login
Route::middleware('auth')->group(function () {

    // Profile route untuk semua user yang login
    Route::get('/profilepage', function () {
        return view('profilepage');
    })->name('profilepage');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        // Admin dashboard
        Route::get('/homeseller', function () {
            return view('homeseller');
        })->name('homeseller');

        // Product Routes untuk admin (gunakan URI yang berbeda atau biarkan ProductController@index ini hanya untuk CRUD admin)
        // Jika Anda ingin admin juga melihat daftar produk (misal untuk pengelolaan), gunakan URI seperti '/admin/products'
        // JIKA ANDA INGIN MENGGUNAKAN ProductController@index SEBAGAI LIST PRODUK ADMIN, GANTI DENGAN INI:
        // Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
        // DAN HAPUS BARIS INI: Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        // KARENA ProductController::class, 'index' sudah di assign ke /products di public routes
        
        // Untuk menghindari konflik, saya sarankan merubah route products.index ini menjadi admin.products.index
        Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index'); // <-- UBAH NAMA ROUTE JADI products.admin.index JIKA PERLU

        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // Ini juga perlu diubah jadi admin/products
        // Penting: Pastikan show product (products.show) tidak konflik dengan productdetail
        // Sebaiknya, route show product admin adalah '/admin/products/{id}'
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show'); // Konflik dengan public productdetail
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        // ... (Route-route Admin lainnya tetap sama)
        // Order Routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // Seller Routes
        Route::get('/sellers', [SellerController::class, 'index'])->name('sellers.index');
        Route::get('/sellers/create', [SellerController::class, 'create'])->name('sellers.create');
        Route::post('/sellers', [SellerController::class, 'store'])->name('sellers.store');
        Route::get('/sellers/{id}', [SellerController::class, 'show'])->name('sellers.show');
        Route::get('/sellers/{id}/edit', [SellerController::class, 'edit'])->name('sellers.edit');
        Route::put('/sellers/{id}', [SellerController::class, 'update'])->name('sellers.update');
        Route::delete('/sellers/{id}', [SellerController::class, 'destroy'])->name('sellers.destroy');

        // Cart Routes (ini untuk manajemen cart oleh admin, bukan cart customer)
        Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
        Route::get('/carts/create', [CartController::class, 'create'])->name('carts.create');
        Route::post('/carts', [CartController::class, 'store'])->name('carts.store');
        Route::get('/carts/{id}', [CartController::class, 'show'])->name('carts.show');
        Route::get('/carts/{id}/edit', [CartController::class, 'edit'])->name('carts.edit');
        Route::put('/carts/{id}', [CartController::class, 'update'])->name('carts.update');
        Route::delete('/carts/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

        // Coins Routes
        Route::get('/coins', [CoinsController::class, 'index'])->name('coins.index');
        Route::get('/coins/create', [CoinsController::class, 'create'])->name('coins.create');
        Route::post('/coins', [CoinsController::class, 'store'])->name('coins.store');
        Route::get('/coins/{id}', [CoinsController::class, 'show'])->name('coins.show');
        Route::get('/coins/{id}/edit', [CoinsController::class, 'edit'])->name('coins.edit');
        Route::put('/coins/{id}', [CoinsController::class, 'update'])->name('coins.update');
        Route::delete('/coins/{id}', [CoinsController::class, 'destroy'])->name('coins.destroy');

        // Exchange Item Routes
        Route::get('/exchange_items', [ExchangeItemController::class, 'index'])->name('exchange_items.index');
        Route::get('/exchange_items/create', [ExchangeItemController::class, 'create'])->name('exchange_items.create');
        Route::post('/exchange_items', [ExchangeItemController::class, 'store'])->name('exchange_items.store');
        Route::get('/exchange_items/{id}', [ExchangeItemController::class, 'show'])->name('exchange_items.show');
        Route::get('/exchange_items/{id}/edit', [ExchangeItemController::class, 'edit'])->name('exchange_items.edit');
        Route::put('/exchange_items/{id}', [ExchangeItemController::class, 'update'])->name('exchange_items.update');
        Route::delete('/exchange_items/{id}', [ExchangeItemController::class, 'destroy'])->name('exchange_items.destroy');

        // Payment Routes
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
        Route::get('/payments/{id}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
        Route::put('/payments/{id}', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');

        // Shipping Routes
        Route::get('/shippings', [ShippingController::class, 'index'])->name('shippings.index');
        Route::get('/shippings/create', [ShippingController::class, 'create'])->name('shippings.create');
        Route::post('/shippings', [ShippingController::class, 'store'])->name('shippings.store');
        Route::get('/shippings/{id}', [ShippingController::class, 'show'])->name('shippings.show');
        Route::get('/shippings/{id}/edit', [ShippingController::class, 'edit'])->name('shippings.edit');
        Route::put('/shippings/{id}', [ShippingController::class, 'update'])->name('shippings.update');
        Route::delete('/shippings/{id}', [ShippingController::class, 'destroy'])->name('shippings.destroy');

        // Voucher Routes
        Route::get('/vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
        Route::post('/vouchers', [VoucherController::class, 'store'])->name('vouchers.store');
        Route::get('/vouchers/{id}', [VoucherController::class, 'show'])->name('vouchers.show');
        Route::get('/vouchers/{id}/edit', [VoucherController::class, 'edit'])->name('vouchers.edit');
        Route::put('/vouchers/{id}', [VoucherController::class, 'update'])->name('vouchers.update');
        Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('vouchers.destroy');

        // Akun Routes
        Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
        Route::get('/akun/create', [AkunController::class, 'create'])->name('akun.create');
        Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
        Route::get('/akun/{id}', [AkunController::class, 'show'])->name('akun.show');
        Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit');
        Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
        Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');

        // API/AJAX Routes
        Route::get('/akun/search', [AkunController::class, 'search'])->name('akun.search');
        Route::get('/akun/by-level', [AkunController::class, 'getByLevel'])->name('akun.by-level');

        // Utility Routes
        Route::get('/akun/export', [AkunController::class, 'export'])->name('akun.export');
        Route::post('/akun/bulk-delete', [AkunController::class, 'bulkDelete'])->name('akun.bulk-delete');

        // Action Routes
        Route::patch('/akun/{id}/toggle-status', [AkunController::class, 'toggleStatus'])->name('akun.toggle-status');
        Route::patch('/akun/{id}/reset-password', [AkunController::class, 'resetPassword'])->name('akun.reset-password');
        Route::patch('/akun/{id}/verify-email', [AkunController::class, 'verifyEmail'])->name('akun.verify-email');
    });

    // Customer routes - hanya untuk user dengan role customer
    Route::middleware('role:customer')->group(function () {
        Route::get('/paymentpage', function () {
        return view('paymentpage');
        })->name('paymentpage');
        
        // Cart route
        Route::get('/productcart', function () {
            return view('productcart');
        })->name('productcart');

        // Order routes untuk customer
        Route::get('/myorderpage', function () {
            return view('myorderpage');
        })->name('myorderpage');

        // Rewards routes
        Route::get('/rewardspage', function () {
            return view('rewardspage');
        })->name('rewardspage');

        // Green cash routes
        Route::get('/greencashpage', function () {
            return view('greencashpage');
        })->name('greencashpage');

        // Payment routes untuk customer
        Route::get('/paymentpage', function () {
            return view('paymentpage');
        })->name('paymentpage');
    });
});