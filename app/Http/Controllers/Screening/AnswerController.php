<?php

namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;
use App\Http\Requests\Screening\SaveAnswerRequest;
use App\Repositories\ScreeningRepository;
use App\Services\SafetyService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(SaveAnswerRequest $request, ScreeningRepository $repo, SafetyService $safetyService)
    {
        $session = $request->active_session;
        
        // CRITICAL: Check safety BEFORE saving
        if ($safetyService->check($request->item_number, $request->answer_value)) {
            $safetyService->triggerEmergency($session);
            
            if ($request->expectsJson()) {
                return response()->json(['redirect' => route('screening.emergency')]);
            }
            return redirect()->route('screening.emergency');
        }

        $repo->saveAnswer($session, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('screening.question');
    }
}
