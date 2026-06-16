<?php

namespace Tests\Unit\Fuzzy;

use Tests\TestCase;
use App\Fuzzy\Aggregator;
use App\Fuzzy\RuleEvaluator;
use App\Fuzzy\DTOs\FuzzyMembership;

/**
 * ============================================================
 * PENGUJIAN TAHAP 2 & 3: Evaluasi Aturan + Agregasi
 * ============================================================
 *
 * Arsitektur 2-Input: evaluate(FuzzyMembership $cognitive, FuzzyMembership $somatic, array $rules)
 * Alpha-cut = min(µ_cognitive, µ_somatic) — tanpa µ_total
 */
class RuleAndAggregationTest extends TestCase
{
    // ─────────────────────────────────────────────────────────────
    // TAHAP 2: Evaluasi Aturan (Operator AND = MIN)
    // ─────────────────────────────────────────────────────────────

    /**
     * Aturan 1: IF kognitif=minimal AND somatik=minimal → alpha=1.0
     */
    public function test_aturan_1_semua_minimal_menghasilkan_alpha_1(): void
    {
        $evaluator            = new RuleEvaluator();
        $membershipsCognitive = new FuzzyMembership(minimal: 1.0, ringan: 0.0, sedang: 0.0, berat: 0.0);
        $membershipsSomatic   = new FuzzyMembership(minimal: 1.0, ringan: 0.0, sedang: 0.0, berat: 0.0);

        $rules = [
            ['antecedent_cognitive' => 'minimal', 'antecedent_somatic' => 'minimal', 'consequent' => 'minimal'],
        ];

        $result = $evaluator->evaluate($membershipsCognitive, $membershipsSomatic, $rules);

        $this->assertCount(1, $result);
        $this->assertSame('minimal', $result[0]['consequent']);
        $this->assertSame(1.0, $result[0]['alpha']);
    }

    /**
     * Aturan 16: IF kognitif=berat AND somatik=berat → alpha=1.0
     */
    public function test_aturan_16_semua_berat_menghasilkan_alpha_1(): void
    {
        $evaluator            = new RuleEvaluator();
        $membershipsCognitive = new FuzzyMembership(minimal: 0.0, ringan: 0.0, sedang: 0.0, berat: 1.0);
        $membershipsSomatic   = new FuzzyMembership(minimal: 0.0, ringan: 0.0, sedang: 0.0, berat: 1.0);

        $rules = [
            ['antecedent_cognitive' => 'berat', 'antecedent_somatic' => 'berat', 'consequent' => 'berat'],
        ];

        $result = $evaluator->evaluate($membershipsCognitive, $membershipsSomatic, $rules);

        $this->assertSame('berat', $result[0]['consequent']);
        $this->assertSame(1.0, $result[0]['alpha']);
    }

    /**
     * Alpha-cut = MIN dari dua antecedent
     * µ_cog_ringan=0.7, µ_som_minimal=1.0
     * alpha = min(0.7, 1.0) = 0.7
     */
    public function test_alpha_cut_adalah_nilai_minimum_dari_dua_antecedent(): void
    {
        $evaluator            = new RuleEvaluator();
        $membershipsCognitive = new FuzzyMembership(minimal: 0.0, ringan: 0.7, sedang: 0.0, berat: 0.0);
        $membershipsSomatic   = new FuzzyMembership(minimal: 1.0, ringan: 0.0, sedang: 0.0, berat: 0.0);

        $rules = [
            ['antecedent_cognitive' => 'ringan', 'antecedent_somatic' => 'minimal', 'consequent' => 'ringan'],
        ];

        $result = $evaluator->evaluate($membershipsCognitive, $membershipsSomatic, $rules);

        $this->assertSame(0.7, $result[0]['alpha']);
        $this->assertSame('ringan', $result[0]['consequent']);
    }

    /**
     * Aturan tidak cocok: salah satu µ=0.0 → alpha=0.0
     */
    public function test_aturan_tidak_cocok_menghasilkan_alpha_0(): void
    {
        $evaluator            = new RuleEvaluator();
        $membershipsCognitive = new FuzzyMembership(minimal: 1.0, ringan: 0.0, sedang: 0.0, berat: 0.0);
        $membershipsSomatic   = new FuzzyMembership(minimal: 1.0, ringan: 0.0, sedang: 0.0, berat: 0.0);

        $rules = [
            // Aturan mencari ringan, tapi membership ringan = 0.0
            ['antecedent_cognitive' => 'ringan', 'antecedent_somatic' => 'ringan', 'consequent' => 'ringan'],
        ];

        $result = $evaluator->evaluate($membershipsCognitive, $membershipsSomatic, $rules);

        $this->assertSame(0.0, $result[0]['alpha']);
    }

    /**
     * Multi-aturan: semua dievaluasi bersamaan
     * µ_cog: minimal=0.8, ringan=0.2 | µ_som: minimal=1.0
     * R1: IF kog=minimal AND som=minimal → min(0.8, 1.0) = 0.8
     * R2: IF kog=ringan  AND som=minimal → min(0.2, 1.0) = 0.2
     * R3: IF kog=ringan  AND som=ringan  → min(0.2, 0.0) = 0.0
     */
    public function test_multi_aturan_semua_dievaluasi_bersamaan(): void
    {
        $evaluator            = new RuleEvaluator();
        $membershipsCognitive = new FuzzyMembership(minimal: 0.8, ringan: 0.2, sedang: 0.0, berat: 0.0);
        $membershipsSomatic   = new FuzzyMembership(minimal: 1.0, ringan: 0.0, sedang: 0.0, berat: 0.0);

        $rules = [
            ['antecedent_cognitive' => 'minimal', 'antecedent_somatic' => 'minimal', 'consequent' => 'minimal'],
            ['antecedent_cognitive' => 'ringan',  'antecedent_somatic' => 'minimal', 'consequent' => 'ringan'],
            ['antecedent_cognitive' => 'ringan',  'antecedent_somatic' => 'ringan',  'consequent' => 'sedang'],
        ];

        $result = $evaluator->evaluate($membershipsCognitive, $membershipsSomatic, $rules);

        $this->assertCount(3, $result);
        $this->assertSame(0.8, $result[0]['alpha']);  // min(0.8, 1.0)
        $this->assertSame(0.2, $result[1]['alpha']);  // min(0.2, 1.0)
        $this->assertSame(0.0, $result[2]['alpha']);  // min(0.2, 0.0)
    }

    // ─────────────────────────────────────────────────────────────
    // TAHAP 3: Agregasi (Operator MAX per himpunan output)
    // ─────────────────────────────────────────────────────────────

    /**
     * MAX per himpunan: minimal=MAX(0.5,0.8)=0.8, ringan=MAX(0.3,0.7)=0.7
     */
    public function test_agregasi_mengambil_max_per_himpunan_output(): void
    {
        $aggregator  = new Aggregator();
        $ruleOutputs = [
            ['consequent' => 'minimal', 'alpha' => 0.5],
            ['consequent' => 'minimal', 'alpha' => 0.8],
            ['consequent' => 'ringan',  'alpha' => 0.3],
            ['consequent' => 'ringan',  'alpha' => 0.7],
            ['consequent' => 'sedang',  'alpha' => 0.0],
            ['consequent' => 'berat',   'alpha' => 0.0],
        ];

        $aggregated = $aggregator->aggregate($ruleOutputs);

        $this->assertSame(0.8, $aggregated['minimal']);
        $this->assertSame(0.7, $aggregated['ringan']);
        $this->assertSame(0.0, $aggregated['sedang']);
        $this->assertSame(0.0, $aggregated['berat']);
    }

    /**
     * Himpunan tanpa aturan aktif → alpha=0.0
     */
    public function test_himpunan_tanpa_aturan_aktif_bernilai_0(): void
    {
        $aggregator  = new Aggregator();
        $ruleOutputs = [['consequent' => 'berat', 'alpha' => 0.9]];

        $aggregated = $aggregator->aggregate($ruleOutputs);

        $this->assertSame(0.9, $aggregated['berat']);
        $this->assertSame(0.0, $aggregated['minimal']);
        $this->assertSame(0.0, $aggregated['ringan']);
        $this->assertSame(0.0, $aggregated['sedang']);
    }

    /**
     * Aturan kosong: semua alpha=0.0
     */
    public function test_agregasi_tanpa_aturan_menghasilkan_semua_nol(): void
    {
        $aggregator = new Aggregator();
        $aggregated = $aggregator->aggregate([]);

        $this->assertSame(['minimal' => 0.0, 'ringan' => 0.0, 'sedang' => 0.0, 'berat' => 0.0], $aggregated);
    }

    /**
     * Tidak menjumlahkan alpha, melainkan MAX:
     * Tiga aturan sedang(0.4, 0.6, 0.3) → MAX=0.6, bukan SUM=1.3
     */
    public function test_agregasi_tidak_menjumlahkan_hanya_mengambil_max(): void
    {
        $aggregator  = new Aggregator();
        $ruleOutputs = [
            ['consequent' => 'sedang', 'alpha' => 0.4],
            ['consequent' => 'sedang', 'alpha' => 0.6],
            ['consequent' => 'sedang', 'alpha' => 0.3],
        ];

        $aggregated = $aggregator->aggregate($ruleOutputs);

        $this->assertSame(0.6, $aggregated['sedang']);  // MAX, bukan SUM=1.3
    }
}
