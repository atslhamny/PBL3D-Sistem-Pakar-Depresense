<?php

namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\SessionStatus;
use App\Services\RecommendationService;

class ResultController extends Controller
{
    public function show(Request $request, RecommendationService $recommendationService)
    {
        $session = $request->active_session;
        
        if ($session->status !== SessionStatus::Completed) {
            return redirect()->route('screening.question');
        }

        $recommendations = $recommendationService->getRecommendations($session->depression_level);

        return view('screening.result', [
            'session' => $session,
            'recommendations' => $recommendations,
        ]);
    }
}
