<?php

namespace Tests\Unit\Fuzzy;

use Tests\TestCase;
use App\Fuzzy\Fuzzification;
use App\Fuzzy\DTOs\FuzzyMembership;

/**
 * ============================================================
 * PENGUJIAN TAHAP 1: Fuzzifikasi (Membership Function)
 * ============================================================
 */
class FuzzificationTest extends TestCase
{
    private Fuzzification $fuzzy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fuzzy = new Fuzzification();
    }

    // ─────────────────────────────────────────────────────────────
    // BAGIAN A: Trapezoid Kiri (Minimal)
    // trapezoidLeft(x, a=0, b=0, c=10, d=14)
    // ─────────────────────────────────────────────────────────────

    public function test_trapezoid_kiri_mengembalikan_1_saat_x_di_plateau(): void
    {
        $this->assertSame(1.0, $this->fuzzy->trapezoidLeft(0.0,  0, 0, 10, 14));
        $this->assertSame(1.0, $this->fuzzy->trapezoidLeft(5.0,  0, 0, 10, 14));
        $this->assertSame(1.0, $this->fuzzy->trapezoidLeft(10.0, 0, 0, 10, 14));
    }

    public function test_trapezoid_kiri_mengembalikan_nilai_turun_di_zona_transisi(): void
    {
        // x=12: (14-12)/(14-10) = 0.5
        $this->assertSame(0.5,  $this->fuzzy->trapezoidLeft(12.0, 0, 0, 10, 14));
        // x=11: (14-11)/(14-10) = 0.75
        $this->assertSame(0.75, $this->fuzzy->trapezoidLeft(11.0, 0, 0, 10, 14));
        // x=13: (14-13)/(14-10) = 0.25
        $this->assertSame(0.25, $this->fuzzy->trapezoidLeft(13.0, 0, 0, 10, 14));
    }

    public function test_trapezoid_kiri_mengembalikan_0_saat_x_di_luar_batas_kanan(): void
    {
        $this->assertSame(0.0, $this->fuzzy->trapezoidLeft(14.0, 0, 0, 10, 14));
        $this->assertSame(0.0, $this->fuzzy->trapezoidLeft(20.0, 0, 0, 10, 14));
        $this->assertSame(0.0, $this->fuzzy->trapezoidLeft(42.0, 0, 0, 10, 14));
    }

    // ─────────────────────────────────────────────────────────────
    // BAGIAN B: Trapezoid (Ringan & Sedang)
    // trapezoid(x, a=10, b=14, c=20, d=24)
    // ─────────────────────────────────────────────────────────────

    public function test_trapezoid_mengembalikan_0_di_luar_batas(): void
    {
        $this->assertSame(0.0, $this->fuzzy->trapezoid(9.0,  10, 14, 20, 24));
        $this->assertSame(0.0, $this->fuzzy->trapezoid(25.0, 10, 14, 20, 24));
        $this->assertSame(0.0, $this->fuzzy->trapezoid(42.0, 10, 14, 20, 24));
    }

    public function test_trapezoid_mengembalikan_nilai_naik_di_sisi_kiri(): void
    {
        // x=12: (12-10)/(14-10) = 0.5
        $this->assertSame(0.5, $this->fuzzy->trapezoid(12.0, 10, 14, 20, 24));
    }

    public function test_trapezoid_mengembalikan_1_di_plateau_atas(): void
    {
        $this->assertSame(1.0, $this->fuzzy->trapezoid(14.0, 10, 14, 20, 24));
        $this->assertSame(1.0, $this->fuzzy->trapezoid(17.0, 10, 14, 20, 24));
        $this->assertSame(1.0, $this->fuzzy->trapezoid(20.0, 10, 14, 20, 24));
    }

    public function test_trapezoid_mengembalikan_nilai_turun_di_sisi_kanan(): void
    {
        // x=22: (24-22)/(24-20) = 0.5
        $this->assertSame(0.5, $this->fuzzy->trapezoid(22.0, 10, 14, 20, 24));
    }

    // ─────────────────────────────────────────────────────────────
    // BAGIAN C: Trapezoid Kanan (Berat)
    // trapezoidRight(x, a=30, b=35, c=42, d=42)
    // ─────────────────────────────────────────────────────────────

    public function test_trapezoid_kanan_mengembalikan_0_sebelum_batas_kiri(): void
    {
        $this->assertSame(0.0, $this->fuzzy->trapezoidRight(0.0,  30, 35, 42, 42));
        $this->assertSame(0.0, $this->fuzzy->trapezoidRight(29.0, 30, 35, 42, 42));
        $this->assertSame(0.0, $this->fuzzy->trapezoidRight(30.0, 30, 35, 42, 42));
    }

    public function test_trapezoid_kanan_mengembalikan_nilai_naik_di_zona_transisi(): void
    {
        // x=32.5: (32.5-30)/(35-30) = 0.5
        $this->assertSame(0.5, $this->fuzzy->trapezoidRight(32.5, 30, 35, 42, 42));
    }

    public function test_trapezoid_kanan_mengembalikan_1_di_plateau_kanan(): void
    {
        $this->assertSame(1.0, $this->fuzzy->trapezoidRight(35.0, 30, 35, 42, 42));
        $this->assertSame(1.0, $this->fuzzy->trapezoidRight(38.0, 30, 35, 42, 42));
        $this->assertSame(1.0, $this->fuzzy->trapezoidRight(42.0, 30, 35, 42, 42));
    }

    // ─────────────────────────────────────────────────────────────
    // BAGIAN D: Segitiga (Triangle)
    // triangle(x, a=10, b=17, c=24)
    // ─────────────────────────────────────────────────────────────

    public function test_triangle_mengembalikan_0_di_luar_batas(): void
    {
        $this->assertSame(0.0, $this->fuzzy->triangle(10.0, 10, 17, 24));
        $this->assertSame(0.0, $this->fuzzy->triangle(24.0, 10, 17, 24));
        $this->assertSame(0.0, $this->fuzzy->triangle(5.0,  10, 17, 24));
    }

    public function test_triangle_mengembalikan_1_di_titik_puncak(): void
    {
        $this->assertSame(1.0, $this->fuzzy->triangle(17.0, 10, 17, 24));
    }

    public function test_triangle_mengembalikan_nilai_naik_di_sisi_kiri(): void
    {
        // x=13.5: (13.5-10)/(17-10) = 0.5
        $this->assertSame(0.5, $this->fuzzy->triangle(13.5, 10, 17, 24));
    }

    public function test_triangle_mengembalikan_nilai_turun_di_sisi_kanan(): void
    {
        // x=20.5: (24-20.5)/(24-17) = 0.5
        $this->assertSame(0.5, $this->fuzzy->triangle(20.5, 10, 17, 24));
    }

    // ─────────────────────────────────────────────────────────────
    // BAGIAN E: Integrasi fuzzify() — Kasus Nyata BDI-II
    // ─────────────────────────────────────────────────────────────

    private function getParamsTotal(): array
    {
        return [
            'minimal' => ['type' => 'trapezoid_left',  'a' => 0,  'b' => 0,  'c' => 10, 'd' => 14],
            'ringan'  => ['type' => 'trapezoid',        'a' => 10, 'b' => 14, 'c' => 20, 'd' => 24],
            'sedang'  => ['type' => 'trapezoid',        'a' => 20, 'b' => 24, 'c' => 30, 'd' => 35],
            'berat'   => ['type' => 'trapezoid_right',  'a' => 30, 'b' => 35, 'c' => 42, 'd' => 42],
        ];
    }

    /**
     * Kasus 1: Skor 5 → µ_minimal=1.0, semua lainnya 0.0
     */
    public function test_fuzzify_skor_5_adalah_anggota_penuh_minimal(): void
    {
        $result = $this->fuzzy->fuzzify(5.0, $this->getParamsTotal());

        $this->assertInstanceOf(FuzzyMembership::class, $result);
        $this->assertSame(1.0, $result->minimal);
        $this->assertSame(0.0, $result->ringan);
        $this->assertSame(0.0, $result->sedang);
        $this->assertSame(0.0, $result->berat);
    }

    /**
     * Kasus 2: Skor 12 → transisi Minimal-Ringan, µ masing-masing 0.5
     * µ_minimal=(14-12)/(14-10)=0.5, µ_ringan=(12-10)/(14-10)=0.5
     */
    public function test_fuzzify_skor_12_adalah_transisi_minimal_ringan(): void
    {
        $result = $this->fuzzy->fuzzify(12.0, $this->getParamsTotal());

        $this->assertSame(0.5, $result->minimal);
        $this->assertSame(0.5, $result->ringan);
        $this->assertSame(0.0, $result->sedang);
        $this->assertSame(0.0, $result->berat);
    }

    /**
     * Kasus 3: Skor 17 → µ_ringan=1.0 (plateau)
     */
    public function test_fuzzify_skor_17_adalah_anggota_penuh_ringan(): void
    {
        $result = $this->fuzzy->fuzzify(17.0, $this->getParamsTotal());

        $this->assertSame(0.0, $result->minimal);
        $this->assertSame(1.0, $result->ringan);
        $this->assertSame(0.0, $result->sedang);
        $this->assertSame(0.0, $result->berat);
    }

    /**
     * Kasus 4: Skor 22 → transisi Ringan-Sedang, µ masing-masing 0.5
     * µ_ringan=(24-22)/(24-20)=0.5, µ_sedang=(22-20)/(24-20)=0.5
     */
    public function test_fuzzify_skor_22_adalah_transisi_ringan_sedang(): void
    {
        $result = $this->fuzzy->fuzzify(22.0, $this->getParamsTotal());

        $this->assertSame(0.0, $result->minimal);
        $this->assertSame(0.5, $result->ringan);
        $this->assertSame(0.5, $result->sedang);
        $this->assertSame(0.0, $result->berat);
    }

    /**
     * Kasus 5: Skor 38 → µ_berat=1.0 (plateau kanan)
     */
    public function test_fuzzify_skor_38_adalah_anggota_penuh_berat(): void
    {
        $result = $this->fuzzy->fuzzify(38.0, $this->getParamsTotal());

        $this->assertSame(0.0, $result->minimal);
        $this->assertSame(0.0, $result->ringan);
        $this->assertSame(0.0, $result->sedang);
        $this->assertSame(1.0, $result->berat);
    }
}
