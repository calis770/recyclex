<<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/landingpage', function () {
    return view('landingpage');
})->name('landingpage');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::get('/homepage', function () {
    return view('homepage');
})->name('homepage');

Route::get('/profilepage', function () {
    return view('profilepage');
})->name('profilepage');

Route::get('/productcart', function () {
    return view('productcart');
})->name('productcart');

Route::get('/productdetail', function () {
    return view('productdetail');
})->name('productdetail');

Route::get('/myorderpage', function () {
    return view('myorderpage');
})->name('myorderpage');