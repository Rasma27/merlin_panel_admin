<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;

class StorefrontController extends Controller
{
    public function index(): View
    {
        return view('welcome', [
            'products' => Product::query()->where('stock', '>', 0)->latest()->take(8)->get(),
        ]);
    }

    public function admin(): View
    {
        return view('dashboard.admin', [
            'productCount' => Product::count(),
            'userCount' => User::count(),
            'orderCount' => Order::count(),
            'orders' => Order::query()->with('user')->latest()->take(8)->get(),
        ]);
    }
}
