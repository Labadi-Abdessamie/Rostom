<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,          // admin, vendor@demo.com, client@demo.com
            ExtraUsersSeeder::class,      // extra client users for reviews
            CategorySeeder::class,        // Electronics/Fashion/Beauty/Home categories
            StoresSeeder::class,         // 4 named stores + fill to 10
            MagasinsSeeder::class,       // factory fill if needed (now respects total)
            RealProductsSeeder::class,   // products assigned to non-demo stores
            ReviewsSeeder::class,         // reviews for seeded products
            BagItemSeeder::class,
            SiteContentSeeder::class,    // About page stats + Team members
        ]);
    }
}
