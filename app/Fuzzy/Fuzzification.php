<?php

namespace App\Fuzzy;

use App\Fuzzy\DTOs\FuzzyMembership;

class Fuzzification
{
    public function fuzzify(float $value, array $params): FuzzyMembership
    {
        return new FuzzyMembership(
            $this->calculate($value, $params['minimal'] ?? []),
            $this->calculate($value, $params['ringan'] ?? []),
            $this->calculate($value, $params['sedang'] ?? []),
            $this->calculate($value, $params['berat'] ?? [])
        );
    }

    private function calculate(float $value, array $param): float
    {
        if (empty($param)) return 0.0;
        
        return match ($param['type']) {
            'trapezoid_left' => $this->trapezoidLeft($value, $param['a'], $param['b'], $param['c'], $param['d']),
            'triangle' => $this->triangle($value, $param['a'], $param['b'], $param['c']),
            'trapezoid_right' => $this->trapezoidRight($value, $param['a'], $param['b'], $param['c'], $param['d']),
            'trapezoid' => $this->trapezoid($value, $param['a'], $param['b'], $param['c'], $param['d']),
            default => 0.0,
        };
    }

    public function trapezoidLeft(float $x, float $a, float $b, float $c, float $d): float
    {
        if ($x <= $c) return 1.0;
        if ($x > $c && $x < $d) return ($d - $x) / ($d - $c);
        return 0.0;
    }

    public function triangle(float $x, float $a, float $b, float $c): float
    {
        if ($x <= $a || $x >= $c) return 0.0;
        if ($x > $a && $x <= $b) return ($x - $a) / ($b - $a);
        if ($x > $b && $x < $c) return ($c - $x) / ($c - $b);
        return 0.0;
    }

    public function trapezoidRight(float $x, float $a, float $b, float $c, float $d): float
    {
        if ($x <= $a) return 0.0;
        if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        if ($x >= $b) return 1.0;
        return 0.0;
    }

    public function trapezoid(float $x, float $a, float $b, float $c, float $d): float
    {
        if ($x <= $a || $x >= $d) return 0.0;
        if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        if ($x >= $b && $x <= $c) return 1.0;
        if ($x > $c && $x < $d) return ($d - $x) / ($d - $c);
        return 0.0;
    }
}
