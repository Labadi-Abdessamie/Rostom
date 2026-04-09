<?php

namespace Database\Seeders;

use App\Models\BagItem;
use App\Models\Category;
use App\Models\Magasin;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in order
        $this->call([
            UsersSeeder::class,
            CategorySeeder::class,
            MagasinsSeeder::class,
            ProductsSeeder::class,
            BagItemSeeder::class,
        ]);
    }
}

