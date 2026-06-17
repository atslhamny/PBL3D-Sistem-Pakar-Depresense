<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admindepresense@gmail.com'],
            [
                'full_name' => 'Administrator',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')),
                'role' => UserRole::Admin,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@depresense.id'],
            [
                'full_name' => 'Test User',
                'password' => Hash::make('password123'),
                'role' => UserRole::User,
            ]
        );
    }
}
