<?php

namespace App\Fuzzy;

use App\Fuzzy\DTOs\FuzzyMembership;

class RuleEvaluator
{
    /**
     * Evaluasi setiap aturan dengan 2 input: Kognitif dan Somatik.
     * Alpha-cut (derajat kebenaran) = min dari kedua nilai keanggotaan.
     */
    public function evaluate(FuzzyMembership $membershipsCognitive, FuzzyMembership $membershipsSomatic, array $rules): array
    {
        $evaluatedRules = [];
        foreach ($rules as $rule) {
            $valCognitive = $this->getMembershipValue($membershipsCognitive, $rule['antecedent_cognitive']);
            $valSomatic   = $this->getMembershipValue($membershipsSomatic, $rule['antecedent_somatic']);

            $alphaCut = min($valCognitive, $valSomatic);

            $evaluatedRules[] = [
                'consequent' => $rule['consequent'],
                'alpha'      => $alphaCut,
            ];
        }
        return $evaluatedRules;
    }

    private function getMembershipValue(FuzzyMembership $membership, ?string $label): float
    {
        if (!$label) return 0.0;
        
        return match ($label) {
            'minimal' => $membership->minimal,
            'ringan'  => $membership->ringan,
            'sedang'  => $membership->sedang,
            'berat'   => $membership->berat,
            default   => 0.0,
        };
    }
}
