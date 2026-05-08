<?php

namespace Database\Seeders;

use App\Models\FuzzyMembershipParam;
use App\Enums\DepressionLevel;
use App\Enums\MembershipFunctionType;
use Illuminate\Database\Seeder;

class FuzzyMembershipSeeder extends Seeder
{
    public function run(): void
    {
        // Total [0-42]
        $this->createParams('total', DepressionLevel::Minimal, MembershipFunctionType::TrapezoidLeft, 0, 0, 10, 14);
        $this->createParams('total', DepressionLevel::Ringan, MembershipFunctionType::Trapezoid, 10, 14, 20, 24);
        $this->createParams('total', DepressionLevel::Sedang, MembershipFunctionType::Trapezoid, 20, 24, 30, 35);
        $this->createParams('total', DepressionLevel::Berat, MembershipFunctionType::TrapezoidRight, 30, 35, 42, 42);

        // Kognitif [0-26] (Proporsi)
        $this->createParams('cognitive', DepressionLevel::Minimal, MembershipFunctionType::TrapezoidLeft, 0, 0, 6, 9);
        $this->createParams('cognitive', DepressionLevel::Ringan, MembershipFunctionType::Trapezoid, 6, 9, 12, 15);
        $this->createParams('cognitive', DepressionLevel::Sedang, MembershipFunctionType::Trapezoid, 12, 15, 18, 22);
        $this->createParams('cognitive', DepressionLevel::Berat, MembershipFunctionType::TrapezoidRight, 18, 22, 26, 26);

        // Somatik [0-16]
        $this->createParams('somatic', DepressionLevel::Minimal, MembershipFunctionType::TrapezoidLeft, 0, 0, 4, 5);
        $this->createParams('somatic', DepressionLevel::Ringan, MembershipFunctionType::Trapezoid, 4, 5, 8, 9);
        $this->createParams('somatic', DepressionLevel::Sedang, MembershipFunctionType::Trapezoid, 8, 9, 12, 13);
        $this->createParams('somatic', DepressionLevel::Berat, MembershipFunctionType::TrapezoidRight, 12, 13, 16, 16);

        // Output [0-100]
        $this->createParams('output', DepressionLevel::Minimal, MembershipFunctionType::TrapezoidLeft, 0, 0, 25, 35);
        $this->createParams('output', DepressionLevel::Ringan, MembershipFunctionType::Trapezoid, 25, 35, 50, 60);
        $this->createParams('output', DepressionLevel::Sedang, MembershipFunctionType::Trapezoid, 50, 60, 75, 85);
        $this->createParams('output', DepressionLevel::Berat, MembershipFunctionType::TrapezoidRight, 75, 85, 100, 100);
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
