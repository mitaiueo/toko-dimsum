<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some demo users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => 'password123',
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'role' => 'customer',
                'password' => Hash::make($userData['password']),
                'email_verified_at' => now(),
            ]);
        }

        $this->command->info('Regular users created successfully.');
    }
}