<?php

namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ScreeningService;
use App\Enums\SessionStatus;

class ScreeningController extends Controller
{
    public function show(Request $request, ScreeningService $service)
    {
        $session = $request->active_session;

        // Legacy support: old sessions that were hard-stopped go to emergency page
        if ($session->status === SessionStatus::EmergencyStopped) {
            return redirect()->route('screening.emergency');
        }

        if ($session->status === SessionStatus::Completed) {
            return redirect()->route('screening.result');
        }

        $nextQuestion = $service->getNextQuestion($session);

        if (!$nextQuestion) {
            // All questions answered — complete and show result
            $service->completeSession($session);
            return redirect()->route('screening.result');
        }

        $progress = ($nextQuestion->sort_order - 1) / 21 * 100;

        return view('screening.question', [
            'question' => $nextQuestion,
            'progress' => $progress,
        ]);
    }
}
