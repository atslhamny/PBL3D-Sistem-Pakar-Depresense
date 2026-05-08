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
        // Seed the database to have parameters and rules
        $this->artisan('db:seed', ['--class' => 'FuzzyMembershipSeeder']);
        $this->artisan('db:seed', ['--class' => 'FuzzyRuleSeeder']);
    }

    public function test_fuzzy_engine_returns_valid_result()
    {
        $engine = app(FuzzyEngine::class);

        // Case 1: Minimal values
        $input = new FuzzyInput(total: 5, cognitive: 3, somatic: 2);
        $result = $engine->run($input);
        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Minimal, $result->depressionLevel);

        // Case 2: Berat values
        $input = new FuzzyInput(total: 35, cognitive: 22, somatic: 13);
        $result = $engine->run($input);
        $this->assertInstanceOf(FuzzyResult::class, $result);
        $this->assertEquals(DepressionLevel::Berat, $result->depressionLevel);
    }
}
