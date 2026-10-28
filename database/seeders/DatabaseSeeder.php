<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::where('email', 'admin@example.com')->update(['email' => 'admin@gmail.com']);
        User::where('email', 'kasir@example.com')->update(['email' => 'kasir@gmail.com']);

        User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'Administrator',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::firstOrCreate(['email' => 'kasir@gmail.com'], [
            'name' => 'Kasir Demo',
            'password' => 'password',
            'role' => 'kasir',
        ]);

        foreach ([
            ['sku' => 'MM-TEA-001', 'name' => 'Teh Melati Premium', 'description' => 'Teh melati pilihan dengan aroma yang lembut.', 'price' => 28000, 'stock' => 24],
            ['sku' => 'MM-COFFEE-001', 'name' => 'Kopi Nusantara', 'description' => 'Kopi lokal pilihan untuk teman beraktivitas.', 'price' => 65000, 'stock' => 18],
            ['sku' => 'MM-CANDLE-001', 'name' => 'Lilin Aromaterapi', 'description' => 'Aroma hangat untuk suasana rumah yang nyaman.', 'price' => 45000, 'stock' => 12],
            ['sku' => 'MM-TOTE-001', 'name' => 'Tas Kanvas Harian', 'description' => 'Tas kanvas praktis untuk kebutuhan sehari-hari.', 'price' => 59000, 'stock' => 15],
        ] as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }
    }
}
