<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $latestSession = $user->screeningSessions()->where('status', 'completed')->latest('completed_at')->first();
        
        $chartData = null;
        if ($latestSession) {
            $sessions = $user->screeningSessions()
                ->where('status', 'completed')
                ->latest('completed_at')
                ->take(5)
                ->get()
                ->reverse(); // Reverse so it goes oldest to newest for the chart

            $chartData = [
                'labels' => $sessions->pluck('completed_at')->map(fn($date) => $date->format('d M'))->toArray(),
                'scores' => $sessions->pluck('score_total')->toArray(),
            ];
        }

        return view('user.dashboard', compact('latestSession', 'chartData'));
    }
}
