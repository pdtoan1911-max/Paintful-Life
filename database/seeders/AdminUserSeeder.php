<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test admin user if not exists
        $email = 'admin@paintful.com';

        $user = User::where('email', $email)->first();

        if (!$user) {
            User::create([
                'email' => $email,
                'password_hash' => Hash::make('password'),
                'full_name' => 'Paintful Admin',
                'phone_number' => '0000000000',
                'address' => '',
                'city' => '',
                'user_type' => 'admin',
                'is_active' => true,
            ]);
        }
    }
}
