<?php

namespace Database\Seeders;

use App\Models\Category;
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

        $categories = collect([
            ['name' => 'Minuman', 'slug' => 'minuman'],
            ['name' => 'Aromaterapi', 'slug' => 'aromaterapi'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
        ]);

        $categoryIds = $categories->mapWithKeys(function (array $category) {
            $model = Category::firstOrCreate(['slug' => $category['slug']], $category);

            return [$category['slug'] => $model->id];
        });

        foreach ([
            ['sku' => 'MM-TEA-001', 'name' => 'Teh Melati Premium', 'description' => 'Teh melati pilihan dengan aroma yang lembut.', 'price' => 28000, 'stock' => 24, 'category_id' => $categoryIds['minuman']],
            ['sku' => 'MM-COFFEE-001', 'name' => 'Kopi Nusantara', 'description' => 'Kopi lokal pilihan untuk teman beraktivitas.', 'price' => 65000, 'stock' => 18, 'category_id' => $categoryIds['minuman']],
            ['sku' => 'MM-CANDLE-001', 'name' => 'Lilin Aromaterapi', 'description' => 'Aroma hangat untuk suasana rumah yang nyaman.', 'price' => 45000, 'stock' => 12, 'category_id' => $categoryIds['aromaterapi']],
            ['sku' => 'MM-TOTE-001', 'name' => 'Tas Kanvas Harian', 'description' => 'Tas kanvas praktis untuk kebutuhan sehari-hari.', 'price' => 59000, 'stock' => 3, 'category_id' => $categoryIds['aksesoris']],
        ] as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }
    }
}
