<?php

namespace Database\Seeders;

use App\Models\FuzzyMembershipParam;
use App\Enums\DepressionLevel;
use App\Enums\MembershipFunctionType;
use Illuminate\Database\Seeder;

/**
 * Parameter Fungsi Keanggotaan Fuzzy
 *
 * Berdasarkan standar klinis BDI-II (Beck et al., 1996):
 *   Minimal : 0 – 13
 *   Ringan  : 14 – 19
 *   Sedang  : 20 – 28
 *   Berat   : 29 – 63 (Total)
 *
 * Variabel Kognitif-Afektif (13 item, max 39):
 *   Proporsi 13/21 dari BDI-II = ~62% dari skor total
 *
 * Variabel Somatik (8 item, max 24):
 *   Proporsi 8/21 dari BDI-II = ~38% dari skor total
 *
 * Overlap antar himpunan disengaja untuk transisi yang halus (Fuzzy).
 */
class FuzzyMembershipSeeder extends Seeder
{
    public function run(): void
    {
        // ── Kognitif-Afektif [0–39] ──────────────────────────────────────────
        // Batas klinis proporsional: Minimal≤8, Ringan 8-13, Sedang 13-18, Berat≥18
        // Overlap ±2 untuk transisi fuzzy yang halus
        $this->createParams('cognitive', DepressionLevel::Minimal, MembershipFunctionType::TrapezoidLeft, 0,  0,  6,  9);
        $this->createParams('cognitive', DepressionLevel::Ringan,  MembershipFunctionType::Trapezoid,     6,  9,  11, 14);
        $this->createParams('cognitive', DepressionLevel::Sedang,  MembershipFunctionType::Trapezoid,     11, 14, 17, 20);
        $this->createParams('cognitive', DepressionLevel::Berat,   MembershipFunctionType::TrapezoidRight,17, 20, 39, 39);

        // ── Somatik [0–24] ──────────────────────────────────────────────────
        // Batas klinis proporsional: Minimal≤5, Ringan 5-8, Sedang 8-11, Berat≥11
        $this->createParams('somatic', DepressionLevel::Minimal, MembershipFunctionType::TrapezoidLeft, 0,  0,  4,  6);
        $this->createParams('somatic', DepressionLevel::Ringan,  MembershipFunctionType::Trapezoid,     4,  6,  8,  9);
        $this->createParams('somatic', DepressionLevel::Sedang,  MembershipFunctionType::Trapezoid,     8,  9,  11, 13);
        $this->createParams('somatic', DepressionLevel::Berat,   MembershipFunctionType::TrapezoidRight,11, 13, 24, 24);

        // ── Output / Crisp [0–100] ──────────────────────────────────────────
        // Representasi persentase keparahan depresi untuk defuzzifikasi (Centroid)
        $this->createParams('output', DepressionLevel::Minimal, MembershipFunctionType::TrapezoidLeft, 0,  0,  15, 25);
        $this->createParams('output', DepressionLevel::Ringan,  MembershipFunctionType::Trapezoid,     15, 25, 40, 50);
        $this->createParams('output', DepressionLevel::Sedang,  MembershipFunctionType::Trapezoid,     40, 50, 65, 75);
        $this->createParams('output', DepressionLevel::Berat,   MembershipFunctionType::TrapezoidRight,65, 75, 100, 100);

        // Hapus params variabel 'total' karena sudah tidak digunakan
        FuzzyMembershipParam::where('variable_name', 'total')->delete();
    }

    private function createParams($var, $label, $type, $a, $b, $c, $d)
    {
        FuzzyMembershipParam::updateOrCreate(
            ['variable_name' => $var, 'linguistic_label' => $label->value],
            [
                'function_type' => $type->value,
                'param_a' => $a,
                'param_b' => $b,
                'param_c' => $c,
                'param_d' => $d,
            ]
        );
    }
}
