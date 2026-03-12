<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin
        User::create([
            'name' => 'Admin demo',
            'email' => 'admin@demo.com',
            'password' => Hash::make('admin'),
            'status' => 'active',
            'role' => 'admin']);
            

        //Vendor
         User::create([
            'name' => 'Vendor demo',
            'email' => 'vendor@demo.com',
            'password' => Hash::make('vendor'),
            'status' => 'active',
            'role' => 'vendor']);

        //Client
        User::create([
        'name' => 'Client Demo',
        'email' => 'client@demo.com',
        'status' => 'active',
        'password' => Hash::make('client'),
        'role' => 'client'
    ]);

    }
}
