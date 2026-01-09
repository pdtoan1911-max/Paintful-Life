<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'john.doe@example.com',
                'password_hash' => Hash::make('password'),
                'full_name' => 'John Doe',
                'phone_number' => '+1234567890',
                'address' => '123 Main St, City, State',
                'city' => 'New York',
                'user_type' => 'customer',
                'is_active' => true,
                'last_login' => now(),
            ],
            [
                'email' => 'jane.smith@example.com',
                'password_hash' => Hash::make('password'),
                'full_name' => 'Jane Smith',
                'phone_number' => '+1234567891',
                'address' => '456 Elm St, City, State',
                'city' => 'Los Angeles',
                'user_type' => 'customer',
                'is_active' => true,
                'last_login' => now()->subDays(1),
            ],
            [
                'email' => 'admin@paintful.com',
                'password_hash' => Hash::make('admin123'),
                'full_name' => 'Admin User',
                'phone_number' => '+1234567892',
                'address' => '789 Oak St, City, State',
                'city' => 'Chicago',
                'user_type' => 'admin',
                'is_active' => true,
                'last_login' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
