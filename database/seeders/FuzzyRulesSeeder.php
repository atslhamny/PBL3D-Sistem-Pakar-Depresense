<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FuzzyRulesSeeder extends Seeder
{
    public function run(): void
    {
        // Format: [rule_number, total, cognitive, somatic, consequent, description]
        $rules = [
            [1,  'minimal','minimal','minimal','minimal', 'Semua aspek minimal → tidak ada depresi'],
            [2,  'minimal','minimal','ringan', 'minimal', 'Somatik ringan namun total & kognitif minimal'],
            [3,  'ringan', 'ringan', 'minimal','ringan',  'Total & kognitif ringan, somatik minimal'],
            [4,  'ringan', 'minimal','ringan', 'ringan',  'Total & somatik ringan, kognitif minimal'],
            [5,  'ringan', 'ringan', 'ringan', 'ringan',  'Semua aspek ringan → depresi ringan'],
            [6,  'sedang', 'ringan', 'sedang', 'sedang',  'Dominasi somatik sedang'],
            [7,  'sedang', 'sedang', 'ringan', 'sedang',  'Dominasi kognitif sedang'],
            [8,  'sedang', 'sedang', 'sedang', 'sedang',  'Semua aspek sedang → depresi sedang'],
            [9,  'sedang', 'berat',  'ringan', 'sedang',  'Kognitif berat tapi total masih sedang'],
            [10, 'berat',  'sedang', 'berat',  'berat',   'Total berat, somatik dominan berat'],
            [11, 'berat',  'berat',  'sedang', 'berat',   'Total berat, kognitif dominan berat'],
            [12, 'berat',  'berat',  'berat',  'berat',   'Semua aspek berat → depresi berat'],
            [13, 'berat',  'berat',  'ringan', 'berat',   'Total & kognitif berat meski somatik ringan'],
            [14, 'berat',  'ringan', 'berat',  'berat',   'Total & somatik berat meski kognitif ringan'],
        ];

        foreach ($rules as [$no, $total, $cog, $som, $cons, $desc]) {
            DB::table('fuzzy_rules')->insert([
                'id'                  => Str::uuid(),
                'rule_number'         => $no,
                'antecedent_total'    => $total,
                'antecedent_cognitive'=> $cog,
                'antecedent_somatic'  => $som,
                'consequent'          => $cons,
                'description'         => $desc,
                'is_active'           => true,
                'created_at'          => now(),
            ]);
        }
    }
}