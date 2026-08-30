<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Real categories matching the project domain
        $categories = [
            'Electronics' => ['Smartphones', 'Laptops', 'Headphones', 'Accessories'],
            'Fashion'     => ["Men's Wear", "Women's Wear", 'Shoes', 'Accessories'],
            'Beauty'      => ['Perfumes', 'Skincare', 'Makeup', 'Haircare'],
            'Home'        => ['Kitchen', 'Decor', 'Bedding', 'Bathroom'],
        ];

        foreach ($categories as $main => $subs) {
            $mainCat = Category::create([
                'name' => $main,
                'status' => 'active',
                'parentId' => null,
            ]);
            foreach ($subs as $subName) {
                Category::create([
                    'name' => $subName,
                    'status' => 'active',
                    'parentId' => $mainCat->id,
                ]);
            }
        }
    }
}
