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
        //User::factory(30)->create();
        Product::factory(40)->create();
        //Magasin::factory(5)->create();
        //Category::factory(3)->create();
        //BagItem::factory(20)->create();
    }
}
