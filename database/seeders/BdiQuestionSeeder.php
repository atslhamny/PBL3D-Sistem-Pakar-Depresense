<?php

namespace Database\Seeders;

use App\Models\BdiQuestion;
use App\Enums\QuestionCategory;
use App\Enums\QuestionSubCategory;
use Illuminate\Database\Seeder;

class BdiQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [];
        
        for ($i = 1; $i <= 21; $i++) {
            $isCognitive = $i <= 13;
            $questions[] = [
                'item_number' => $i,
                'question_text' => "Pertanyaan BDI-II Nomor $i",
                'category' => $isCognitive ? QuestionCategory::KognitifAfektif->value : QuestionCategory::Somatik->value,
                'sub_category' => $isCognitive ? QuestionSubCategory::Kognitif->value : QuestionSubCategory::Fisik->value,
                'is_safety_item' => ($i === 9),
                'safety_threshold' => 2,
                'sort_order' => $i,
                'is_locked' => true,
            ];
        }

        foreach ($questions as $q) {
            BdiQuestion::updateOrCreate(['item_number' => $q['item_number']], $q);
        }
    }
}
