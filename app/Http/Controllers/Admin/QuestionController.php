<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BdiQuestion;
use App\Enums\QuestionSubCategory;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = BdiQuestion::ordered()->get();
        
        $cognitiveQuestions = $questions->where('sub_category', QuestionSubCategory::Kognitif);
        $somaticQuestions = $questions->where('sub_category', QuestionSubCategory::Fisik);
        
        $totalCount = $questions->count();
        $checkedCount = $questions->where('is_locked', true)->count();
        $progressPercent = $totalCount > 0 ? round(($checkedCount / $totalCount) * 100) : 0;

        return view('admin.questions.index', compact(
            'cognitiveQuestions',
            'somaticQuestions',
            'totalCount',
            'checkedCount',
            'progressPercent'
        ));
    }
}
