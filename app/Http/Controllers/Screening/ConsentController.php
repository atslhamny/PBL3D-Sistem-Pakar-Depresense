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
    /** Interval minimum antar screening (selaras dengan periode retrospektif BDI-II). */
    const COOLDOWN_DAYS = 14;

    public function show()
    {
        return view('screening.consent');
    }

    public function store(StartScreeningRequest $request, ScreeningRepository $repo)
    {
        $userId = auth()->id();

        // ── Rate Limiting: Hanya user login yang dibatasi cooldown 14 hari ────
        if ($userId) {
            $cooldownResult = $this->checkCooldown($userId);
            if ($cooldownResult !== null) {
                return redirect()->route('screening.consent')
                    ->with('cooldown_active', $cooldownResult);
            }
        }

        // ── Guest: jika sudah punya sesi in_progress, lanjutkan ──────────────
        if (!$userId) {
            $token = session('guest_session_token');
            if ($token) {
                $existingSession = ScreeningSession::where('session_token', $token)
                    ->where('status', SessionStatus::InProgress)
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '>', now())
                    ->first();

                if ($existingSession) {
                    return redirect()->route('screening.question');
                }
                // Sesi expired / selesai → buat session baru
            }
        }

        $session = $repo->createSession($userId);

        if (!$userId) {
            session(['guest_session_token' => $session->session_token]);
        }

        return redirect()->route('screening.question');
    }

    /**
     * Periksa apakah user masih dalam periode cooldown 14 hari.
     *
     * @return array|null  null = boleh screening, array = data cooldown (jika masih harus tunggu)
     */
    private function checkCooldown(int $userId): ?array
    {
        $lastSession = ScreeningSession::where('user_id', $userId)
            ->whereIn('status', [
                SessionStatus::Completed,
                SessionStatus::EmergencyStopped,
            ])
            ->latest('completed_at')
            ->first();

        if (!$lastSession) {
            return null; // Belum pernah screening → boleh
        }

        $completedAt  = \Carbon\Carbon::parse($lastSession->completed_at ?? $lastSession->created_at)->timezone(config('app.timezone'));
        $nextAllowed  = $completedAt->copy()->addDays(self::COOLDOWN_DAYS);

        if (now()->timezone(config('app.timezone'))->lt($nextAllowed)) {
            $daysLeft = (int) now()->timezone(config('app.timezone'))->diffInDays($nextAllowed, false) + 1;
            return [
                'days_left'       => $daysLeft,
                'next_allowed_at' => $nextAllowed->translatedFormat('d F Y'),
                'last_completed'  => $completedAt->translatedFormat('d F Y'),
            ];
        }

        return null; // Sudah lewat 14 hari → boleh
    }
}

