<?php

namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ScreeningRepository;
use App\Http\Requests\Screening\StartScreeningRequest;
use App\Models\ScreeningSession;
use App\Enums\SessionStatus;

class ConsentController extends Controller
{
    public function show()
    {
        return view('screening.consent');
    }

    public function store(StartScreeningRequest $request, ScreeningRepository $repo)
    {
        $userId = auth()->id();

        // Bug #3-A: Jika guest sudah punya session in_progress, lanjutkan saja
        if (!$userId) {
            $token = session('guest_session_token');
            if ($token) {
                $existingSession = ScreeningSession::where('session_token', $token)
                    ->where('status', SessionStatus::InProgress)
                    ->first();

                if ($existingSession) {
                    return redirect()->route('screening.question');
                }
                // Jika completed/emergency_stopped → buat session baru (Bonus-A)
            }
        }

        $session = $repo->createSession($userId);

        if (!$userId) {
            session(['guest_session_token' => $session->session_token]);
        }

        return redirect()->route('screening.question');
    }
}
