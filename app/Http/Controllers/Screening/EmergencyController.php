<?php

namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\SessionStatus;

class EmergencyController extends Controller
{
    public function show(Request $request)
    {
        $session = $request->active_session;
        
        if ($session->status !== SessionStatus::EmergencyStopped) {
            return redirect()->route('home');
        }

        return view('screening.emergency');
    }
}
