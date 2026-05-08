<?php

namespace Database\Seeders;

use App\Models\FuzzyRule;
use Illuminate\Database\Seeder;

class FuzzyRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            [1, 'minimal', 'minimal', 'minimal', 'minimal'],
            [2, 'ringan', 'ringan', 'minimal', 'ringan'],
            [3, 'ringan', 'minimal', 'ringan', 'ringan'],
            [4, 'sedang', 'sedang', 'ringan', 'sedang'],
            [5, 'sedang', 'ringan', 'sedang', 'sedang'],
            [6, 'berat', 'berat', 'sedang', 'berat'],
            [7, 'berat', 'sedang', 'berat', 'berat'],
            [8, 'berat', 'berat', 'berat', 'berat'],
            [9, 'ringan', 'ringan', 'ringan', 'ringan'],
            [10, 'sedang', 'sedang', 'sedang', 'sedang'],
            [11, 'minimal', 'ringan', 'minimal', 'minimal'],
            [12, 'sedang', 'berat', 'ringan', 'sedang'],
            [13, 'berat', 'sedang', 'ringan', 'sedang'],
            [14, 'ringan', 'sedang', 'minimal', 'ringan'],
        ];

        foreach ($rules as $r) {
            FuzzyRule::updateOrCreate(
                ['rule_number' => $r[0]],
                [
                    'antecedent_total' => $r[1],
                    'antecedent_cognitive' => $r[2],
                    'antecedent_somatic' => $r[3],
                    'consequent' => $r[4],
                    'description' => "If total is {$r[1]} AND cognitive is {$r[2]} AND somatic is {$r[3]} THEN output is {$r[4]}",
                    'is_active' => true,
                ]
            );
        }
    }
}
