<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExtraUsersSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'Amine Boudjellal', 'email' => 'amine@demo.com'],
            ['name' => 'Sarah Mansouri', 'email' => 'sarah@demo.com'],
            ['name' => 'Karim Belkacem', 'email' => 'karim@demo.com'],
            ['name' => 'Lina Hadj', 'email' => 'lina@demo.com'],
            ['name' => 'Youcef Ait Ali', 'email' => 'youcef@demo.com'],
        ];

        foreach ($clients as $client) {
            User::updateOrCreate(['email' => $client['email']], [
                'name' => $client['name'],
                'password' => Hash::make('password'),
                'status' => 'active',
                'role' => 'client',
            ]);
        }
    }
}
