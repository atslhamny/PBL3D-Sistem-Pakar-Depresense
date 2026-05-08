<?php

namespace App\Repositories;

use App\Models\ScreeningSession;
use App\Enums\SessionStatus;
use Illuminate\Support\Str;
use Exception;

class ScreeningRepository
{
    public function createSession(?int $userId = null): ScreeningSession
    {
        return ScreeningSession::create([
            'user_id' => $userId,
            'session_token' => $userId ? null : Str::random(32),
            'status' => SessionStatus::InProgress,
            'informed_consent_at' => now(),
        ]);
    }

    public function saveAnswer(ScreeningSession $session, array $data): void
    {
        if ($session->status === SessionStatus::EmergencyStopped) {
            throw new Exception("Cannot save answer. Session was stopped due to emergency protocol.");
        }

        $session->answers()->updateOrCreate(
            ['question_id' => $data['question_id']],
            ['answer_value' => $data['answer_value']]
        );
    }
}
