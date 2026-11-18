<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:10,1')->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin-dashboard', [StorefrontController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');
    Route::resource('/manage/products', ProductController::class)
        ->except(['show'])
        ->middleware('role:admin')
        ->names('admin.products');

    Route::get('/kasir', [OrderController::class, 'index'])->middleware('role:kasir')->name('cashier.dashboard');
    Route::post('/kasir/orders', [OrderController::class, 'store'])->middleware('role:kasir')->name('cashier.orders.store');
    Route::get('/orders/{order}/receipt', [InvoiceController::class, 'receipt'])->name('orders.receipt');
    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'show'])->name('orders.invoice');
});
