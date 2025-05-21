<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@okamidimsum.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create secondary admin if needed
        User::create([
            'name' => 'Manager',
            'email' => 'manager@okamidimsum.com',
            'role' => 'admin',
            'password' => Hash::make('manager123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin users created successfully.');
    }
}