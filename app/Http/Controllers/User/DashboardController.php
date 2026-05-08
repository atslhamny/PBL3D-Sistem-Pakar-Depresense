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
        return view('user.dashboard', compact('latestSession'));
    }
}
