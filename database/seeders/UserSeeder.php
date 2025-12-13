<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create demo users
        User::create([
            'name' => 'Demo Customer',
            'email' => 'customer@demo.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@eisalon.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $this->command->info('✅ Demo users created!');
        $this->command->info('📧 customer@demo.com / password123');
        $this->command->info('📧 admin@eisalon.com / admin123');
    }
}
