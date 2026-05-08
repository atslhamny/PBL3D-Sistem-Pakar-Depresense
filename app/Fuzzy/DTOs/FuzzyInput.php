<?php

namespace App\Fuzzy\DTOs;

readonly class FuzzyInput
{
    public function __construct(
        public int $total,
        public int $cognitive,
        public int $somatic
    ) {}
}
