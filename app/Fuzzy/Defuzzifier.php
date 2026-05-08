<?php

namespace App\Fuzzy;

use App\Fuzzy\DTOs\FuzzyResult;
use App\Enums\DepressionLevel;

class Defuzzifier
{
    public function __construct(private Fuzzification $fuzzification) {}

    public function centroid(array $aggregated, array $outputParams, float $step = 0.1): FuzzyResult
    {
        $numerator = 0.0;
        $denominator = 0.0;

        if (empty($outputParams)) {
            return new FuzzyResult(0.0, DepressionLevel::Minimal);
        }

        for ($z = 0.0; $z <= 100.0; $z += $step) {
            $muMinimal = min($aggregated['minimal'], $this->fuzzification->trapezoidLeft($z, $outputParams['minimal']['a'], $outputParams['minimal']['b'], $outputParams['minimal']['c'], $outputParams['minimal']['d']));
            $muRingan = min($aggregated['ringan'], $this->fuzzification->trapezoid($z, $outputParams['ringan']['a'], $outputParams['ringan']['b'], $outputParams['ringan']['c'], $outputParams['ringan']['d']));
            $muSedang = min($aggregated['sedang'], $this->fuzzification->trapezoid($z, $outputParams['sedang']['a'], $outputParams['sedang']['b'], $outputParams['sedang']['c'], $outputParams['sedang']['d']));
            $muBerat = min($aggregated['berat'], $this->fuzzification->trapezoidRight($z, $outputParams['berat']['a'], $outputParams['berat']['b'], $outputParams['berat']['c'], $outputParams['berat']['d']));

            $muMax = max($muMinimal, $muRingan, $muSedang, $muBerat);

            $numerator += $z * $muMax;
            $denominator += $muMax;
        }

        $centroidValue = $denominator == 0 ? 0.0 : $numerator / $denominator;

        $level = $this->determineLevel($centroidValue, $outputParams);

        return new FuzzyResult(round($centroidValue, 2), $level);
    }

    private function determineLevel(float $centroidValue, array $outputParams): DepressionLevel
    {
        $muMinimal = $this->fuzzification->trapezoidLeft($centroidValue, $outputParams['minimal']['a'], $outputParams['minimal']['b'], $outputParams['minimal']['c'], $outputParams['minimal']['d']);
        $muRingan = $this->fuzzification->trapezoid($centroidValue, $outputParams['ringan']['a'], $outputParams['ringan']['b'], $outputParams['ringan']['c'], $outputParams['ringan']['d']);
        $muSedang = $this->fuzzification->trapezoid($centroidValue, $outputParams['sedang']['a'], $outputParams['sedang']['b'], $outputParams['sedang']['c'], $outputParams['sedang']['d']);
        $muBerat = $this->fuzzification->trapezoidRight($centroidValue, $outputParams['berat']['a'], $outputParams['berat']['b'], $outputParams['berat']['c'], $outputParams['berat']['d']);

        $maxMu = max($muMinimal, $muRingan, $muSedang, $muBerat);

        if ($maxMu == $muBerat) return DepressionLevel::Berat;
        if ($maxMu == $muSedang) return DepressionLevel::Sedang;
        if ($maxMu == $muRingan) return DepressionLevel::Ringan;
        return DepressionLevel::Minimal;
    }
}
