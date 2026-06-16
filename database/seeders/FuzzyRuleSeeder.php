<?php

namespace Database\Seeders;

use App\Models\FuzzyRule;
use Illuminate\Database\Seeder;

/**
 * Basis Aturan Fuzzy Mamdani — Arsitektur 2 Input Variable
 *
 * Input 1: Sub-skor Kognitif-Afektif (Pertanyaan 1-13, range 0-39)
 * Input 2: Sub-skor Somatik          (Pertanyaan 14-21, range 0-24)
 * Output : Tingkat Keparahan Depresi (Centroid 0-100)
 *
 * Jumlah Aturan: 4 × 4 = 16 aturan
 * 
 * Dasar Penetapan Konsekuen:
 * Disusun berdasarkan panduan klinis BDI-II (Beck et al., 1996) di mana
 * gejala kognitif-afektif memiliki bobot klinis lebih besar dalam
 * penetapan keparahan depresi dibandingkan gejala somatik. 
 * Bila terjadi disparitas, gejala kognitif menjadi penentu utama.
 *
 * Referensi:
 * - Beck, A.T., Steer, R.A., & Brown, G.K. (1996). Manual for the BDI-II.
 * - Alberdi et al. (2022). Fuzzy Logic-Based System for Depression 
 *   Classification using Psychometric Scores. MDPI Brain Sciences, 12(9).
 */
class FuzzyRuleSeeder extends Seeder
{
    public function run(): void
    {
        // Format: [no, kognitif, somatik, output]
        // Konsekuen ditentukan dengan prinsip:
        // → Kognitif = penentu utama (dominan)
        // → Somatik  = penentu sekunder (moderating)
        // → Bila keduanya berbeda 1 tingkat, ambil yang lebih berat
        // → Bila berbeda 2+ tingkat, ambil rata-rata (pembulatan ke atas)
        
        $rules = [
            // Kognitif: Minimal
            [1,  'minimal', 'minimal', 'minimal'],
            [2,  'minimal', 'ringan',  'minimal'],
            [3,  'minimal', 'sedang',  'ringan'],
            [4,  'minimal', 'berat',   'ringan'],

            // Kognitif: Ringan
            [5,  'ringan',  'minimal', 'ringan'],
            [6,  'ringan',  'ringan',  'ringan'],
            [7,  'ringan',  'sedang',  'sedang'],
            [8,  'ringan',  'berat',   'sedang'],

            // Kognitif: Sedang
            [9,  'sedang',  'minimal', 'sedang'],
            [10, 'sedang',  'ringan',  'sedang'],
            [11, 'sedang',  'sedang',  'sedang'],
            [12, 'sedang',  'berat',   'berat'],

            // Kognitif: Berat
            [13, 'berat',   'minimal', 'sedang'],
            [14, 'berat',   'ringan',  'berat'],
            [15, 'berat',   'sedang',  'berat'],
            [16, 'berat',   'berat',   'berat'],
        ];

        foreach ($rules as $r) {
            FuzzyRule::updateOrCreate(
                ['rule_number' => $r[0]],
                [
                    'antecedent_total'     => null, // Tidak digunakan di arsitektur 2-input
                    'antecedent_cognitive' => $r[1],
                    'antecedent_somatic'   => $r[2],
                    'consequent'           => $r[3],
                    'description'          => "IF kognitif IS {$r[1]} AND somatik IS {$r[2]} THEN output IS {$r[3]}",
                    'is_active'            => true,
                ]
            );
        }

        // Hapus rule lama (nomor 17-64 dari seeder sebelumnya)
        FuzzyRule::where('rule_number', '>', 16)->delete();
    }
}
