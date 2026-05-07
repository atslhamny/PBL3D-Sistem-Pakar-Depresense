<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id'            => Str::uuid(),
            'email'         => 'admin@sistempakar.id',
            'password_hash' => Hash::make('Admin@12345'),
            'full_name'     => 'Administrator',
            'role'          => 'admin',
            'is_verified'   => true,
            'is_active'     => true,
        ]);
    }
}