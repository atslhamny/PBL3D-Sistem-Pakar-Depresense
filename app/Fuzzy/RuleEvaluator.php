<?php

namespace App\Fuzzy;

use App\Fuzzy\DTOs\FuzzyMembership;

class RuleEvaluator
{
    public function evaluate(FuzzyMembership $membershipsTotal, FuzzyMembership $membershipsCognitive, FuzzyMembership $membershipsSomatic, array $rules): array
    {
        $evaluatedRules = [];
        foreach ($rules as $rule) {
            $valTotal = $this->getMembershipValue($membershipsTotal, $rule['antecedent_total']);
            $valCognitive = $this->getMembershipValue($membershipsCognitive, $rule['antecedent_cognitive']);
            $valSomatic = $this->getMembershipValue($membershipsSomatic, $rule['antecedent_somatic']);

            $alphaCut = min($valTotal, $valCognitive, $valSomatic);
            
            $evaluatedRules[] = [
                'consequent' => $rule['consequent'],
                'alpha' => $alphaCut
            ];
        }
        return $evaluatedRules;
    }

    private function getMembershipValue(FuzzyMembership $membership, string $label): float
    {
        return match ($label) {
            'minimal' => $membership->minimal,
            'ringan' => $membership->ringan,
            'sedang' => $membership->sedang,
            'berat' => $membership->berat,
            default => 0.0,
        };
    }
}
