<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $latestSession = $user->screeningSessions()->where('status', \App\Enums\SessionStatus::Completed)->latest('completed_at')->first();
        
        $chartData = null;
        if ($latestSession) {
            $sessions = $user->screeningSessions()
                ->where('status', \App\Enums\SessionStatus::Completed)
                ->latest('completed_at')
                ->take(5)
                ->get()
                ->reverse(); // Reverse so it goes oldest to newest for the chart

            $chartData = [
                'labels' => $sessions->pluck('completed_at')->map(fn($date) => $date->format('d M'))->toArray(),
                'scores' => $sessions->pluck('score_total')->toArray(),
            ];
        }

        $activeSession = $user->screeningSessions()
            ->where('status', \App\Enums\SessionStatus::InProgress)
            ->whereNotNull('expires_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        return view('user.dashboard', compact('latestSession', 'chartData', 'activeSession'));
    }
}
