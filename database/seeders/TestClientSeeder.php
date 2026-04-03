<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists
        if (!User::where('email', 'testclient@demo.com')->exists()) {
            User::create([
                'name' => 'Test Client',
                'email' => 'testclient@demo.com',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'role' => 'client'
            ]);
        }
    }
}
