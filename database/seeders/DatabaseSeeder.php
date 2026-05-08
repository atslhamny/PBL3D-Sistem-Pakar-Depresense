<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            BdiQuestionSeeder::class,
            FuzzyMembershipSeeder::class,
            FuzzyRuleSeeder::class,
        ]);
    }
}
