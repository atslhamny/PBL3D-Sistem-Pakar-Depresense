<?php

namespace App\Repositories;

use App\Models\ScreeningSession;
use App\Enums\SessionStatus;
use Illuminate\Support\Str;
use Exception;

class ScreeningRepository
{
    /** Durasi batas waktu sesi dalam menit (selaras dengan BDI-II ≈ 5–10 menit). */
    const SESSION_TIMEOUT_MINUTES = 30;

    public function createSession(?int $userId = null): ScreeningSession
    {
        return ScreeningSession::create([
            'user_id'            => $userId,
            'session_token'      => $userId ? null : Str::random(32),
            'status'             => SessionStatus::InProgress,
            'informed_consent_at'=> now(),
            'expires_at'         => now()->addMinutes(self::SESSION_TIMEOUT_MINUTES),
        ]);
    }

    /**
     * Tandai sesi sebagai expired karena batas waktu habis.
     * Sesi yang expired tidak bisa dilanjutkan — user harus mulai dari awal.
     */
    public function expireSession(ScreeningSession $session): void
    {
        $session->update(['status' => SessionStatus::Expired]);
    }

    public function saveAnswer(ScreeningSession $session, array $data): void
    {
        if ($session->status === SessionStatus::EmergencyStopped) {
            throw new Exception("Cannot save answer. Session was stopped due to emergency protocol.");
        }

        if ($session->status === SessionStatus::Expired) {
            throw new Exception("Cannot save answer. Session has expired.");
        }

        $session->answers()->updateOrCreate(
            ['question_id' => $data['question_id']],
            ['answer_value' => $data['answer_value']]
        );
    }
}

