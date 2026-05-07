<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FuzzyMembershipParamsSeeder extends Seeder
{
    public function run(): void
    {
        $params = [
            // ── total BDI-II (0–63) ──────────────────────────
            ['total','minimal','trapezoid_left',   0,  0,  10, 14],
            ['total','ringan', 'triangle',         10, 16, 20, 20],
            ['total','sedang', 'triangle',         17, 24, 29, 29],
            ['total','berat',  'trapezoid_right',  26, 30, 63, 63],

            // ── cognitive_affective (0–39, item 1–13) ────────
            ['cognitive','minimal','trapezoid_left',   0,  0,  6,  9 ],
            ['cognitive','ringan', 'triangle',         6,  10, 13, 13],
            ['cognitive','sedang', 'triangle',         10, 15, 18, 18],
            ['cognitive','berat',  'trapezoid_right',  15, 19, 39, 39],

            // ── somatic (0–24, item 14–21) ────────────────────
            ['somatic','minimal','trapezoid_left',   0,  0,  4,  6 ],
            ['somatic','ringan', 'triangle',         4,  7,  9,  9 ],
            ['somatic','sedang', 'triangle',         7,  10, 12, 12],
            ['somatic','berat',  'trapezoid_right',  10, 13, 24, 24],

            // ── output / centroid (0–100) ─────────────────────
            ['output','minimal','trapezoid_left',   0,  0,  15, 25 ],
            ['output','ringan', 'triangle',         15, 35, 50, 50 ],
            ['output','sedang', 'triangle',         40, 55, 70, 70 ],
            ['output','berat',  'trapezoid_right',  60, 75, 100,100],
        ];

        foreach ($params as [$var, $label, $type, $a, $b, $c, $d]) {
            DB::table('fuzzy_membership_params')->insert([
                'id'              => Str::uuid(),
                'variable_name'   => $var,
                'linguistic_label'=> $label,
                'function_type'   => $type,
                'param_a'         => $a,
                'param_b'         => $b,
                'param_c'         => $c,
                'param_d'         => $d,
                'updated_at'      => now(),
            ]);
        }
    }
}