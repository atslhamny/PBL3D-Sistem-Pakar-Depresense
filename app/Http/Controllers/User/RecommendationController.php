<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RecommendationService;

class RecommendationController extends Controller
{
    public function index(RecommendationService $recommendationService)
    {
        $user = auth()->user();
        $latestSession = $user->screeningSessions()->where('status', 'completed')->latest('completed_at')->first();
        
        $recommendations = [];
        if ($latestSession) {
            $recommendations = $recommendationService->getRecommendations($latestSession->depression_level);
        }

        return view('user.recommendation', compact('latestSession', 'recommendations'));
    }
}
