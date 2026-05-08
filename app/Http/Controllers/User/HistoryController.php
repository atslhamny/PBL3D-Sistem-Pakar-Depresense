<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $sessions = $user->screeningSessions()->where('status', 'completed')->orderBy('completed_at', 'asc')->get();
        
        $chartData = [
            'labels' => $sessions->pluck('completed_at')->map(fn($date) => $date->format('d M Y'))->toArray(),
            'scores' => $sessions->pluck('score_total')->toArray(),
            'fuzzy_values' => $sessions->pluck('fuzzy_centroid_value')->toArray(),
        ];

        return view('user.history', compact('sessions', 'chartData'));
    }
}
