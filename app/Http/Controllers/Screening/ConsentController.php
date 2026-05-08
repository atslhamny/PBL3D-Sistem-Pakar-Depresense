<?php

namespace App\Http\Controllers\Screening;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ScreeningRepository;
use App\Http\Requests\Screening\StartScreeningRequest;

class ConsentController extends Controller
{
    public function show()
    {
        return view('screening.consent');
    }

    public function store(StartScreeningRequest $request, ScreeningRepository $repo)
    {
        $userId = auth()->id();
        $session = $repo->createSession($userId);
        
        if (!$userId) {
            session(['guest_session_token' => $session->session_token]);
        }

        return redirect()->route('screening.question');
    }
}
