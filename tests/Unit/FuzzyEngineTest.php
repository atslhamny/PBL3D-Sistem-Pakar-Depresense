<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Fuzzy\FuzzyEngine;
use App\Fuzzy\DTOs\FuzzyInput;
use App\Fuzzy\DTOs\FuzzyResult;
use App\Enums\DepressionLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuzzyEngineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'FuzzyMembershipSeeder']);
        $this->artisan('db:seed', ['--class' => 'FuzzyRuleSeeder']);
    }

    public function test_fuzzy_engine_returns_valid_result()
    {
        $engine = app(FuzzyEngine::class);

        // Case 1: Nilai minimal — tidak ada gejala berarti
        $input = new FuzzyInput(cognitive: 3, somatic: 2);
        $result = $engine->run($input);
        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Minimal, $result->depressionLevel);

        // Case 2: Nilai berat — gejala kognitif dan somatik keduanya tinggi
        $input = new FuzzyInput(cognitive: 22, somatic: 13);
        $result = $engine->run($input);
        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Berat, $result->depressionLevel);
    }
}
