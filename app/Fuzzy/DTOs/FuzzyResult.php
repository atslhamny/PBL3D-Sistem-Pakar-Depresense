<?php

namespace App\Fuzzy\DTOs;

use App\Enums\DepressionLevel;

readonly class FuzzyResult
{
    public function __construct(
        public float $centroid,
        public DepressionLevel $depressionLevel
    ) {}
}
