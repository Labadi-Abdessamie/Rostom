<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Magasin;

class MagasinsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only fill up to 10 total stores (StoresSeeder creates the named ones first)
        $toCreate = max(0, 10 - Magasin::count());
        if ($toCreate > 0) {
            Magasin::factory($toCreate)->create();
        }
    }
}

