<?php

namespace Tests\Unit\Fuzzy;

use Tests\TestCase;
use App\Fuzzy\FuzzyEngine;
use App\Fuzzy\DTOs\FuzzyInput;
use App\Fuzzy\DTOs\FuzzyResult;
use App\Enums\DepressionLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * ============================================================
 * PENGUJIAN TAHAP 5: Integrasi Penuh FuzzyEngine (End-to-End)
 * ============================================================
 * Menguji pipeline lengkap Mamdani:
 *   Input BDI-II → Fuzzifikasi → Evaluasi Aturan → Agregasi → Defuzzifikasi → Output
 *
 * Setiap kasus uji merepresentasikan profil mahasiswa nyata dengan
 * skor kognitif-afektif dan skor somatik dari BDI-II.
 *
 * Referensi Klasifikasi BDI-II (Beck et al., 1996):
 *   Minimal  : 0–13
 *   Ringan   : 14–19
 *   Sedang   : 20–28
 *   Berat    : 29–63
 *
 * Arsitektur Input Sistem (2-Input Fuzzy Mamdani):
 *   - cognitive: Sub-skor Kognitif-Afektif (item 1-13, range 0-39)
 *   - somatic  : Sub-skor Somatik (item 14-21, range 0-24)
 */
class FuzzyEngineIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'FuzzyMembershipSeeder']);
        $this->artisan('db:seed', ['--class' => 'FuzzyRuleSeeder']);
    }

    // ─────────────────────────────────────────────────────────────
    // KELOMPOK 1: Kasus Normal (Nilai representatif setiap kategori)
    // ─────────────────────────────────────────────────────────────

    /** TC-INT-01: Profil Minimal Khas — mahasiswa tanpa gejala depresi berarti */
    public function test_TC_INT_01_profil_minimal_murni(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 3, somatic: 2);

        $result = $engine->run($input);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Minimal, $result->depressionLevel,
            "TC-INT-01 GAGAL: Skor (kog:3,som:2) seharusnya Minimal, dapat: {$result->depressionLevel->value}");
    }

    /** TC-INT-02: Profil Ringan Khas — gejala ringan, belum perlu intervensi klinis */
    public function test_TC_INT_02_profil_ringan_khas(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 10, somatic: 7);

        $result = $engine->run($input);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Ringan, $result->depressionLevel,
            "TC-INT-02 GAGAL: Skor (kog:10,som:7) seharusnya Ringan, dapat: {$result->depressionLevel->value}");
    }

    /** TC-INT-03: Profil Sedang Khas — gejala moderat, perlu evaluasi profesional */
    public function test_TC_INT_03_profil_sedang_khas(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 16, somatic: 9);

        $result = $engine->run($input);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Sedang, $result->depressionLevel,
            "TC-INT-03 GAGAL: Skor (kog:16,som:9) seharusnya Sedang, dapat: {$result->depressionLevel->value}");
    }

    /** TC-INT-04: Profil Berat Khas — gejala berat, memerlukan penanganan segera */
    public function test_TC_INT_04_profil_berat_khas(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 23, somatic: 14);

        $result = $engine->run($input);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Berat, $result->depressionLevel,
            "TC-INT-04 GAGAL: Skor (kog:23,som:14) seharusnya Berat, dapat: {$result->depressionLevel->value}");
    }

    // ─────────────────────────────────────────────────────────────
    // KELOMPOK 2: Nilai Batas (Boundary Values)
    // ─────────────────────────────────────────────────────────────

    /** TC-BV-01: Nilai minimum absolut — semua nol */
    public function test_TC_BV_01_nilai_minimum_absolut(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 0, somatic: 0);

        $result = $engine->run($input);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Minimal, $result->depressionLevel,
            'TC-BV-01 GAGAL: Skor (0,0) seharusnya Minimal');
        $this->assertGreaterThanOrEqual(0.0, $result->centroid);
    }

    /** TC-BV-02: Nilai maksimum absolut — semua maksimum */
    public function test_TC_BV_02_nilai_maksimum_absolut(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 39, somatic: 24);

        $result = $engine->run($input);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Berat, $result->depressionLevel,
            'TC-BV-02 GAGAL: Skor (kog:39,som:24) seharusnya Berat');
        $this->assertGreaterThan(75.0, $result->centroid);
    }

    /** TC-BV-03: Tepat di area plateau Minimal */
    public function test_TC_BV_03_batas_atas_minimal(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 6, somatic: 4);

        $result = $engine->run($input);

        $this->assertEquals(DepressionLevel::Minimal, $result->depressionLevel,
            'TC-BV-03 GAGAL: Skor (kog:6,som:4) seharusnya Minimal (di plateau)');
    }

    /** TC-BV-04: Tepat di titik transisi Minimal↔Ringan */
    public function test_TC_BV_04_titik_transisi_minimal_ke_ringan(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 8, somatic: 5);

        $result = $engine->run($input);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        // Nilai ini berada di zona transisi, hasil bisa Minimal atau Ringan
        $this->assertContains($result->depressionLevel, [DepressionLevel::Minimal, DepressionLevel::Ringan],
            "TC-BV-04 GAGAL: Skor (kog:8,som:5) seharusnya Minimal atau Ringan (transisi)");
    }

    /** TC-BV-05: Tepat di batas bawah Berat */
    public function test_TC_BV_05_batas_bawah_berat(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 18, somatic: 12);

        $result = $engine->run($input);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        // Pada batas ini, µ_berat mulai naik dari 0
        $this->assertContains($result->depressionLevel, [DepressionLevel::Sedang, DepressionLevel::Berat],
            "TC-BV-05 GAGAL: Skor (kog:18,som:12) seharusnya Sedang atau Berat (transisi)");
    }

    // ─────────────────────────────────────────────────────────────
    // KELOMPOK 3: Validasi Format Output
    // ─────────────────────────────────────────────────────────────

    /** TC-FO-01: Output selalu bertipe FuzzyResult */
    public function test_TC_FO_01_output_selalu_instance_of_FuzzyResult(): void
    {
        $engine = app(FuzzyEngine::class);

        $testCases = [
            new FuzzyInput(3,  2),
            new FuzzyInput(10, 7),
            new FuzzyInput(16, 9),
            new FuzzyInput(23, 14),
        ];

        foreach ($testCases as $input) {
            $result = $engine->run($input);
            $this->assertInstanceOf(FuzzyResult::class, $result,
                "TC-FO-01 GAGAL: FuzzyEngine::run() harus selalu mengembalikan FuzzyResult");
        }
    }

    /** TC-FO-02: crispValue selalu dalam rentang [0, 100] */
    public function test_TC_FO_02_crisp_value_dalam_domain_output(): void
    {
        $engine = app(FuzzyEngine::class);

        $testCases = [
            new FuzzyInput(0,  0),
            new FuzzyInput(3,  2),
            new FuzzyInput(13, 8),
            new FuzzyInput(39, 24),
        ];

        foreach ($testCases as $input) {
            $result = $engine->run($input);
            $this->assertGreaterThanOrEqual(0.0, $result->centroid,
                "TC-FO-02 GAGAL: centroid tidak boleh < 0");
            $this->assertLessThanOrEqual(100.0, $result->centroid,
                "TC-FO-02 GAGAL: centroid tidak boleh > 100");
        }
    }

    /** TC-FO-03: depressionLevel selalu salah satu dari 4 kategori valid */
    public function test_TC_FO_03_depression_level_selalu_valid(): void
    {
        $engine  = app(FuzzyEngine::class);
        $valid   = [
            DepressionLevel::Minimal,
            DepressionLevel::Ringan,
            DepressionLevel::Sedang,
            DepressionLevel::Berat,
        ];

        $testCases = [
            new FuzzyInput(2,  1),
            new FuzzyInput(9,  5),
            new FuzzyInput(17, 10),
            new FuzzyInput(25, 14),
        ];

        foreach ($testCases as $input) {
            $result = $engine->run($input);
            $this->assertContains($result->depressionLevel, $valid,
                "TC-FO-03 GAGAL: depressionLevel harus salah satu dari 4 kategori yang valid");
        }
    }

    /** TC-FO-04: Sistem deterministik – input yang sama selalu menghasilkan output yang sama */
    public function test_TC_FO_04_sistem_deterministik(): void
    {
        $engine = app(FuzzyEngine::class);
        $input  = new FuzzyInput(cognitive: 13, somatic: 8);

        $resultA = $engine->run($input);
        $resultB = $engine->run($input);

        $this->assertEquals($resultA->centroid,         $resultB->centroid,
            'TC-FO-04 GAGAL: Sistem harus deterministik (centroid)');
        $this->assertEquals($resultA->depressionLevel,  $resultB->depressionLevel,
            'TC-FO-04 GAGAL: Sistem harus deterministik (depressionLevel)');
    }

    // ─────────────────────────────────────────────────────────────
    // KELOMPOK 4: Konsistensi Monotonisitas
    // ─────────────────────────────────────────────────────────────

    /**
     * TC-MO-01: Skor lebih tinggi → crispValue tidak lebih kecil (monoton naik)
     * Menjamin logika sistem tidak berlawanan dengan intuisi klinis
     */
    public function test_TC_MO_01_crisp_value_monoton_naik(): void
    {
        $engine = app(FuzzyEngine::class);

        $cases = [
            new FuzzyInput(2,  1),   // sangat rendah
            new FuzzyInput(6,  4),   // rendah
            new FuzzyInput(13, 8),   // sedang-bawah
            new FuzzyInput(20, 12),  // sedang-atas
            new FuzzyInput(25, 15),  // sangat tinggi
        ];

        $prevCrisp = -1.0;
        foreach ($cases as $idx => $input) {
            $result = $engine->run($input);
            $this->assertGreaterThanOrEqual($prevCrisp, $result->centroid,
                "TC-MO-01 GAGAL pada kasus ke-{$idx}: centroid ({$result->centroid}) tidak naik dari sebelumnya ({$prevCrisp}). Sistem tidak monoton.");
            $prevCrisp = $result->centroid;
        }
    }
}
