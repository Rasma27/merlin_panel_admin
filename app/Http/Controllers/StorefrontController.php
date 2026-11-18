<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class StorefrontController extends Controller
{
    public function index(): View
    {
        return view('welcome', [
            'products' => Product::query()->where('stock', '>', 0)->latest()->take(8)->get(),
        ]);
    }

    public function admin(): RedirectResponse
    {
        return redirect('/admin');
    }
}
