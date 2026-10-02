<?php

namespace Database\Seeders;

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
    }
}
