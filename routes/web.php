<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:10,1')->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::view('/admin', 'dashboard.admin')->middleware('role:admin')->name('admin.dashboard');
    Route::view('/kasir', 'dashboard.cashier')->middleware('role:kasir')->name('cashier.dashboard');
});
