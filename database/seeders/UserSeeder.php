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
                'email' => 'admin@paintful.com',
                'password_hash' => Hash::make('admin123'),
                'full_name' => 'Admin User',
                'phone_number' => '+1234567892',
                'address' => 'số 25, Tương mai',
                'city' => 'Hà Nội',
                'district' => 'Hoàng Mai',
                'user_type' => 'admin',
                'is_active' => true,
                'last_login' => now(),
            ],
            [
                'email' => 'john.doe@example.com',
                'password_hash' => Hash::make('password'),
                'full_name' => 'John Doe',
                'phone_number' => '+1234567890',
                'address' => 'số 10, Trần Duy Hưng',
                'city' => 'Hà Nội',
                'district' => 'Cầu Giấy',
                'user_type' => 'customer',
                'is_active' => true,
                'last_login' => now(),
            ],
            [
                'email' => 'jane.smith@example.com',
                'password_hash' => Hash::make('password'),
                'full_name' => 'Jane Smith',
                'phone_number' => '+1234567891',
                'address' => 'số 45, Nguyễn Trãi',
                'city' => 'Hà Nội',
                'district' => 'Đống Đa',
                'user_type' => 'customer',
                'is_active' => true,
                'last_login' => now()->subDays(1),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
