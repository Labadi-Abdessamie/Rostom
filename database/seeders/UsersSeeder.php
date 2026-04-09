<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Magasin;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin
        User::updateOrCreate(['email' => 'admin@demo.com'], [
            'name'     => 'Admin demo',
            'password' => Hash::make('admin'),
            'status'   => 'active',
            'role'     => 'admin',
        ]);

        //Vendor
        $vendor = User::updateOrCreate(['email' => 'vendor@demo.com'], [
            'name'     => 'Vendor demo',
            'password' => Hash::make('vendor'),
            'status'   => 'active',
            'role'     => 'vendor',
        ]);

        Magasin::updateOrCreate(['user_id' => $vendor->id], [
            'name'        => 'Demo Store',
            'email'       => 'vendor@demo.com',
            'phoneNumber' => '0555000000',
            'bio'         => 'Official demo vendor store.',
            'location'    => 'Algiers, Algeria',
            'magasinOpen' => true,
            'status'      => 'active',
            'balance'     => 0,
            'rate'        => 0,
            'rate_count'  => 0,
            'category_id' => Category::value('id'),
        ]);

        //Client
        User::updateOrCreate(['email' => 'client@demo.com'], [
            'name'     => 'Client Demo',
            'status'   => 'active',
            'password' => Hash::make('client'),
            'role'     => 'client',
        ]);
    }
}
