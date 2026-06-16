<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = $user->screeningSessions()
            ->whereIn('status', [\App\Enums\SessionStatus::Completed, \App\Enums\SessionStatus::EmergencyStopped])
            ->latest('completed_at');
            
        if ($request->filled('level') && $request->level !== 'Semua') {
            $query->where('depression_level', \App\Enums\DepressionLevel::from(strtolower($request->level)));
        }

        $sessions = $query->paginate(10)->withQueryString();

        return view('user.history', compact('sessions'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $session = $user->screeningSessions()
            ->whereIn('status', [\App\Enums\SessionStatus::Completed, \App\Enums\SessionStatus::EmergencyStopped])
            ->findOrFail($id);

        return view('user.insight', compact('session'));
    }
}
