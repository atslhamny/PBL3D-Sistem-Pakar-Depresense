<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ScreeningSession;
use App\Enums\SessionStatus;
use App\Repositories\ScreeningRepository;

class EnsureConsentGiven
{
    public function __construct(private ScreeningRepository $repo) {}

    public function handle(Request $request, Closure $next): Response
    {
        $session = $this->resolveActiveSession($request);

        if (!$session) {
            return $this->redirectToConsent($request);
        }

        // ── Cek: Sesi sudah berstatus expired (di-expire sebelumnya) ─────────
        if ($session->status === SessionStatus::Expired) {
            return $this->redirectExpired($request);
        }

        // ── Cek: Sesi in_progress yang melewati batas waktu 30 menit ─────────
        if ($session->isExpired()) {
            $this->repo->expireSession($session);
            return $this->redirectExpired($request);
        }

        // ── Sesi valid: inject ke request dan lanjut ─────────────────────────
        $request->merge([
            'active_session'    => $session,
            'remaining_seconds' => $session->remainingSeconds(),
        ]);

        return $next($request);
    }

    /** Temukan sesi aktif milik user login atau guest berdasarkan token. */
    private function resolveActiveSession(Request $request): ?ScreeningSession
    {
        if (auth()->check()) {
            return auth()->user()->screeningSessions()
                ->whereNotNull('informed_consent_at')
                ->latest()
                ->first();
        }

        $token = session('guest_session_token');
        if ($token) {
            return ScreeningSession::where('session_token', $token)
                ->whereNotNull('informed_consent_at')
                ->first();
        }

        return null;
    }

    /** Redirect ke halaman consent tanpa sesi aktif. */
    private function redirectToConsent(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['redirect' => route('screening.consent')], 403);
        }

        return redirect()->route('screening.consent');
    }

    /** Redirect ke consent dengan pesan bahwa sesi telah kadaluarsa. */
    private function redirectExpired(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'redirect' => route('screening.consent'),
                'message'  => 'Sesi telah berakhir.',
            ], 403);
        }

        return redirect()->route('screening.consent')
            ->with('session_expired', true);
    }
}

