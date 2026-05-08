<?php

namespace App\Fuzzy;

class Aggregator
{
    public function aggregate(array $ruleOutputs): array
    {
        $aggregated = [
            'minimal' => 0.0,
            'ringan' => 0.0,
            'sedang' => 0.0,
            'berat' => 0.0,
        ];

        foreach ($ruleOutputs as $output) {
            $label = $output['consequent'];
            if (isset($aggregated[$label]) && $output['alpha'] > $aggregated[$label]) {
                $aggregated[$label] = $output['alpha'];
            }
        }

        return $aggregated;
    }
}
