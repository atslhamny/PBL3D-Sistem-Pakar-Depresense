<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Enums\QuestionCategory;

class ScoringService
{
    public function calculateScores(Collection $answers): array
    {
        $total = 0;
        $cognitive = 0;
        $somatic = 0;

        foreach ($answers as $answer) {
            $total += $answer->answer_value;
            
            if ($answer->question->category === QuestionCategory::KognitifAfektif) {
                $cognitive += $answer->answer_value;
            } else if ($answer->question->category === QuestionCategory::Somatik) {
                $somatic += $answer->answer_value;
            }
        }

        return [
            'total' => $total,
            'cognitive' => $cognitive,
            'somatic' => $somatic,
        ];
    }
}
