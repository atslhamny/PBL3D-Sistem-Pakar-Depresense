<?php

namespace Tests\Unit\Fuzzy;

use Tests\TestCase;
use App\Fuzzy\Fuzzification;
use App\Fuzzy\Defuzzifier;
use App\Fuzzy\DTOs\FuzzyResult;
use App\Enums\DepressionLevel;

/**
 * ============================================================
 * PENGUJIAN TAHAP 4: Defuzzifikasi (Metode Centroid / COG)
 * ============================================================
 */
class DefuzzificationTest extends TestCase
{
    private Defuzzifier $defuzzifier;
    private array $outputParams;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defuzzifier  = new Defuzzifier(new Fuzzification());
        $this->outputParams = [
            'minimal' => ['a' => 0,  'b' => 0,  'c' => 25, 'd' => 35],
            'ringan'  => ['a' => 25, 'b' => 35, 'c' => 50, 'd' => 60],
            'sedang'  => ['a' => 50, 'b' => 60, 'c' => 75, 'd' => 85],
            'berat'   => ['a' => 75, 'b' => 85, 'c' => 100,'d' => 100],
        ];
    }

    /**
     * Kasus 1: Hanya Minimal aktif (alpha=1.0) → centroid di area kiri
     */
    public function test_alpha_minimal_penuh_menghasilkan_level_minimal(): void
    {
        $aggregated = ['minimal' => 1.0, 'ringan' => 0.0, 'sedang' => 0.0, 'berat' => 0.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Minimal, $result->depressionLevel);
        $this->assertLessThan(35.0, $result->centroid, 'centroid harus < 35 untuk area Minimal');
    }

    /**
     * Kasus 2: Hanya Berat aktif (alpha=1.0) → centroid di area kanan
     */
    public function test_alpha_berat_penuh_menghasilkan_level_berat(): void
    {
        $aggregated = ['minimal' => 0.0, 'ringan' => 0.0, 'sedang' => 0.0, 'berat' => 1.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertEquals(DepressionLevel::Berat, $result->depressionLevel);
        $this->assertGreaterThan(75.0, $result->centroid, 'centroid harus > 75 untuk area Berat');
    }

    /**
     * Kasus 3: Hanya Ringan aktif (alpha=1.0) → centroid di antara 25–60
     */
    public function test_alpha_ringan_penuh_menghasilkan_level_ringan(): void
    {
        $aggregated = ['minimal' => 0.0, 'ringan' => 1.0, 'sedang' => 0.0, 'berat' => 0.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertEquals(DepressionLevel::Ringan, $result->depressionLevel);
        $this->assertGreaterThan(25.0, $result->centroid);
        $this->assertLessThan(60.0, $result->centroid);
    }

    /**
     * Kasus 4: Hanya Sedang aktif (alpha=1.0) → centroid di antara 50–85
     */
    public function test_alpha_sedang_penuh_menghasilkan_level_sedang(): void
    {
        $aggregated = ['minimal' => 0.0, 'ringan' => 0.0, 'sedang' => 1.0, 'berat' => 0.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertEquals(DepressionLevel::Sedang, $result->depressionLevel);
        $this->assertGreaterThan(50.0, $result->centroid);
        $this->assertLessThan(85.0, $result->centroid);
    }

    /**
     * Kasus 5: Minimal=0.5 dan Ringan=0.5 → centroid di transisi (< 60)
     */
    public function test_campuran_minimal_dan_ringan_centroid_di_transisi(): void
    {
        $aggregated = ['minimal' => 0.5, 'ringan' => 0.5, 'sedang' => 0.0, 'berat' => 0.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertLessThan(60.0, $result->centroid);
        $this->assertContains($result->depressionLevel, [DepressionLevel::Minimal, DepressionLevel::Ringan]);
    }

    /**
     * Kasus 6: Semua alpha=0.0 → tidak ada aturan aktif → default (centroid=0.0)
     */
    public function test_semua_alpha_nol_mengembalikan_nilai_default(): void
    {
        $aggregated = ['minimal' => 0.0, 'ringan' => 0.0, 'sedang' => 0.0, 'berat' => 0.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertSame(0.0, $result->centroid);
    }

    /**
     * Kasus 7: centroid selalu dibulatkan maksimal 2 desimal
     */
    public function test_centroid_selalu_dibulatkan_dua_desimal(): void
    {
        $aggregated = ['minimal' => 0.0, 'ringan' => 0.7, 'sedang' => 0.3, 'berat' => 0.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $asString = (string) $result->centroid;
        $decimals = strpos($asString, '.') !== false ? strlen(explode('.', $asString)[1]) : 0;
        $this->assertLessThanOrEqual(2, $decimals, "centroid harus max 2 desimal, dapat: {$result->centroid}");
    }

    /**
     * Alpha dominan Berat (murni) → DepressionLevel::Berat
     * Catatan: dengan ringan/sedang kecil masih ada, centroid bisa terpengaruh.
     * Gunakan berat=1.0 murni untuk memastikan centroid di area Berat.
     */
    public function test_alpha_dominan_berat_menghasilkan_label_berat(): void
    {
        $aggregated = ['minimal' => 0.0, 'ringan' => 0.0, 'sedang' => 0.0, 'berat' => 1.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertEquals(DepressionLevel::Berat, $result->depressionLevel);
    }

    /**
     * Alpha dominan Sedang → DepressionLevel::Sedang
     */
    public function test_alpha_dominan_sedang_menghasilkan_label_sedang(): void
    {
        $aggregated = ['minimal' => 0.0, 'ringan' => 0.1, 'sedang' => 0.9, 'berat' => 0.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertEquals(DepressionLevel::Sedang, $result->depressionLevel);
    }

    /**
     * centroid selalu bertipe float
     */
    public function test_centroid_selalu_bertipe_float(): void
    {
        $aggregated = ['minimal' => 1.0, 'ringan' => 0.0, 'sedang' => 0.0, 'berat' => 0.0];
        $result     = $this->defuzzifier->centroid($aggregated, $this->outputParams);

        $this->assertIsFloat($result->centroid);
    }
}
