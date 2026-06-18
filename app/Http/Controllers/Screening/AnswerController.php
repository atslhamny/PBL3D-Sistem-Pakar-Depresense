<?php

namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;
use App\Http\Requests\Screening\SaveAnswerRequest;
use App\Repositories\ScreeningRepository;
use App\Services\SafetyService;
use App\Services\ScreeningService;

class AnswerController extends Controller
{
    public function store(
        SaveAnswerRequest $request,
        ScreeningRepository $repo,
        SafetyService $safetyService,
        ScreeningService $screeningService
    ) {
        $session = $request->active_session;

        // SAFETY CHECK: If suicide ideation answer detected, flag the session
        // but do NOT stop screening — the user continues all questions
        // and will see an emergency banner on the result page.
        if ($safetyService->check($request->item_number, $request->answer_value)) {
            $safetyService->flagSafetyAlert($session);
        }

        // Always save the answer
        $repo->saveAnswer($session, $request->validated());

        // ── Inline next-question payload (zero full-page reload) ──────────
        if ($request->expectsJson()) {
            $nextQuestion = $screeningService->getNextQuestion($session);

            if (!$nextQuestion) {
                // All 21 questions answered → complete session, send redirect URL
                $screeningService->completeSession($session);
                return response()->json([
                    'done'     => true,
                    'redirect' => route('screening.result'),
                ]);
            }

            // Build shuffled options: answer_options is a plain indexed array [0=>'teks0', 1=>'teks1', ...]
            // We build [{value:0, text:...}, ...] then shuffle so display order is random
            // but the submitted `value` always maps to the correct backend score.
            $rawOptions = $nextQuestion->answer_options; // cast to array by model
            $pairs = array_map(
                fn($value) => ['value' => $value, 'text' => $rawOptions[$value]],
                array_keys($rawOptions)
            );
            shuffle($pairs);

            $progress = ($nextQuestion->sort_order - 1) / 21 * 100;

            return response()->json([
                'done'     => false,
                'question' => [
                    'id'          => $nextQuestion->id,
                    'item_number' => $nextQuestion->item_number,
                    'text'        => $nextQuestion->question_text,
                    'category'    => $nextQuestion->item_number <= 13
                                        ? 'Kognitif-Afektif'
                                        : 'Somatik',
                    'is_last'     => $nextQuestion->item_number === 21,
                    'options'     => $pairs,
                ],
                'progress' => round($progress),
            ]);
        }

        // Non-AJAX fallback (browser without JS)
        return redirect()->route('screening.question');
    }
}
