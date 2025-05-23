<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Create 10 users
        User::factory()->count(10)->create();

        // Optionally create a specific user
        User::create([
            'name' => 'Alvin Kigen',
            'email' => 'alvinkigen+laravel@outlook.com',
            'email_verified_at' => now(),
            'phone' => '(289) 933-7195',
            'password' => Hash::make('password123'),
            'kyc_status' => 'verified',
            'remember_token' => Str::random(10),
        ]);
    }
}
