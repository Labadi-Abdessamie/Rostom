<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Magasin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StoresSeeder extends Seeder
{
    public function run(): void
    {
        // Get main categories to assign each store a primary category
        $mainCategories = Category::whereNull('parentId')->get();

        // Named vendor stores
        $stores = [
            ['name' => 'TechZone DZ', 'email' => 'techzone@demo.com', 'location' => 'Algiers, Bab Ezzouar', 'category' => 'Electronics'],
            ['name' => 'Fashion House DZ', 'email' => 'fashionhouse@demo.com', 'location' => 'Oran, City Center', 'category' => 'Fashion'],
            ['name' => 'Beauty Corner', 'email' => 'beautycorner@demo.com', 'location' => 'Constantine, El Khroub', 'category' => 'Beauty'],
            ['name' => 'Home Comfort Store', 'email' => 'homecomfort@demo.com', 'location' => 'Annaba, Sidi Amar', 'category' => 'Home'],
        ];

        $poolIndex = 0;
        foreach ($stores as $store) {
            $user = User::updateOrCreate(['email' => $store['email']], [
                'name' => ucfirst(explode('@', $store['email'])[0]),
                'password' => Hash::make('password'),
                'status' => 'active',
                'role' => 'vendor',
            ]);

            $mainCat = $mainCategories->firstWhere('name', $store['category']);
            $catId = $mainCat ? $mainCat->id : $mainCategories->first()->id;

            Magasin::updateOrCreate(['user_id' => $user->id], [
                'name' => $store['name'],
                'email' => $store['email'],
                'phoneNumber' => '0' . (550000000 + $poolIndex),
                'bio' => 'Welcome to ' . $store['name'] . ' — your one-stop shop for quality ' . strtolower($store['category']) . ' products.',
                'location' => $store['location'],
                'latitude' => 36.7 + ($poolIndex * 0.05),
                'longitude' => 3.0 + ($poolIndex * 0.1),
                'magasinOpen' => true,
                'status' => 'active',
                'balance' => 0,
                'rate' => 0,
                'rate_count' => 0,
                'category_id' => $catId,
            ]);
            $poolIndex++;
        }

        // Fill remaining slots with factory-generated stores
        $existingMagasinCount = Magasin::count();
        $targetCount = 10;
        $toCreate = max(0, $targetCount - $existingMagasinCount);
        if ($toCreate > 0) {
            Magasin::factory($toCreate)->create();
        }
    }
}
