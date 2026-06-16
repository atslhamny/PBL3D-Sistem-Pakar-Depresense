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

        // SAFETY CHECK: If suicide ideation answer detected, flag the session
        // but do NOT stop screening — the user continues all questions
        // and will see an emergency banner on the result page.
        if ($safetyService->check($request->item_number, $request->answer_value)) {
            $safetyService->flagSafetyAlert($session);
        }

        // Always save the answer and move to the next question
        $repo->saveAnswer($session, $request->validated());

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('screening.question');
    }
}
