<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create main cateogries
        Category::factory()->count(5)->create();
        //Create subcategories
        Category::factory()->count(10)->child()->create();
    }
}
