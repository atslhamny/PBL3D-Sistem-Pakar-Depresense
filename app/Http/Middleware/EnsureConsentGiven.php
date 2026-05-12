<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ScreeningSession;

class EnsureConsentGiven
{
    public function handle(Request $request, Closure $next): Response
    {
        $session = null;
        if (auth()->check()) {
            $session = auth()->user()->screeningSessions()
                ->whereNotNull('informed_consent_at')
                ->latest()
                ->first();
        } else {
            $token = session('guest_session_token');
            if ($token) {
                $session = ScreeningSession::where('session_token', $token)
                    ->whereNotNull('informed_consent_at')
                    ->first();
            }
        }

        if (!$session) {

            if ($request->expectsJson()) {
                return response()->json([
                    'redirect' => route('screening.consent')
                ], 403);
            }

            return redirect()->route('screening.consent');
        }

        $request->merge(['active_session' => $session]);

        return $next($request);
    }
}
