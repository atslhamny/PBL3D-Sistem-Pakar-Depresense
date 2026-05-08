<?php

namespace App\Fuzzy\DTOs;

readonly class FuzzyMembership
{
    public function __construct(
        public float $minimal,
        public float $ringan,
        public float $sedang,
        public float $berat
    ) {}
}
