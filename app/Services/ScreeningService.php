<?php

namespace App\Services;

use App\Models\ScreeningSession;
use App\Models\BdiQuestion;
use App\Enums\SessionStatus;
use App\Fuzzy\FuzzyEngine;
use App\Fuzzy\DTOs\FuzzyInput;

class ScreeningService
{
    public function __construct(
        private ScoringService $scoringService,
        private FuzzyEngine $fuzzyEngine
    ) {}

    public function getNextQuestion(ScreeningSession $session): ?BdiQuestion
    {
        $answeredIds = $session->answers()->pluck('question_id')->toArray();
        
        return BdiQuestion::whereNotIn('id', $answeredIds)
            ->ordered()
            ->first();
    }

    public function completeSession(ScreeningSession $session): void
    {
        $answers = $session->answers()->with('question')->get();
        $scores = $this->scoringService->calculateScores($answers);
        
        $fuzzyInput = new FuzzyInput($scores['total'], $scores['cognitive'], $scores['somatic']);
        $fuzzyResult = $this->fuzzyEngine->run($fuzzyInput);

        $session->update([
            'status' => SessionStatus::Completed,
            'score_total' => $scores['total'],
            'score_cognitive_affective' => $scores['cognitive'],
            'score_somatic' => $scores['somatic'],
            'fuzzy_centroid_value' => $fuzzyResult->centroid,
            'depression_level' => $fuzzyResult->depressionLevel,
            'completed_at' => now(),
        ]);
    }
}
