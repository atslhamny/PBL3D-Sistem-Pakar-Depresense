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
            ['email' => 'admin@depresense.id'],
            [
                'full_name' => 'Administrator',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')),
                'role' => UserRole::Admin,
            ]
        );
    }
}
