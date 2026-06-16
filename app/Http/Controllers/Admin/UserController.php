<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ScreeningSession;
use App\Enums\DepressionLevel;
use App\Enums\SessionStatus;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->withCount('screeningSessions')
            ->with(['screeningSessions' => function ($q) {
                $q->latest()->limit(1);
            }]);

        // Search by name or email — minimum 3 characters required
        if ($request->filled('search') && strlen($request->search) >= 3) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'perlu_perhatian') {
                $query->whereHas('screeningSessions', function ($q) {
                    $q->whereIn('depression_level', [DepressionLevel::Berat, DepressionLevel::Sedang])
                      ->orWhere('status', SessionStatus::EmergencyStopped);
                });
            } elseif ($status === 'stabil') {
                $query->whereHas('screeningSessions', function ($q) {
                    $q->whereIn('depression_level', [DepressionLevel::Minimal, DepressionLevel::Ringan]);
                })->whereDoesntHave('screeningSessions', function ($q) {
                    $q->whereIn('depression_level', [DepressionLevel::Berat, DepressionLevel::Sedang])
                      ->orWhere('status', SessionStatus::EmergencyStopped);
                });
            } elseif ($status === 'belum_screening') {
                $query->doesntHave('screeningSessions');
            }
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        // Map users with status info
        $users->getCollection()->transform(function ($user) {
            $lastSession = $user->screeningSessions->first();
            $user->last_session = $lastSession;
            $user->user_status = $this->resolveUserStatus($lastSession);
            return $user;
        });

        $totalUsers = User::where('role', 'user')->count();
        $perluPerhatianCount = User::where('role', 'user')->whereHas('screeningSessions', function ($q) {
            $q->whereIn('depression_level', [DepressionLevel::Berat, DepressionLevel::Sedang])
              ->orWhere('status', SessionStatus::EmergencyStopped);
        })->count();
        $belumScreeningCount = User::where('role', 'user')->doesntHave('screeningSessions')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'perluPerhatianCount',
            'belumScreeningCount'
        ));
    }

    public function show(User $user)
    {
        $sessions = ScreeningSession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalScreenings = $sessions->count();
        $completedScreenings = $sessions->where('status', SessionStatus::Completed)->count();
        $emergencyCount = $sessions->where('status', SessionStatus::EmergencyStopped)->count();

        // Chart data: last 5 sessions trend
        $recentSessions = $sessions->take(5)->reverse()->values();
        $chartLabels = $recentSessions->map(fn($s) => $s->created_at->format('d M'))->toArray();
        $chartScores = $recentSessions->map(fn($s) => $s->score_total ?? 0)->toArray();

        $lastSession = $sessions->first();
        $userStatus = $this->resolveUserStatus($lastSession);

        return view('admin.users.show', compact(
            'user',
            'sessions',
            'totalScreenings',
            'completedScreenings',
            'emergencyCount',
            'chartLabels',
            'chartScores',
            'lastSession',
            'userStatus'
        ));
    }

    private function resolveUserStatus(?ScreeningSession $session): string
    {
        if (!$session) return 'Belum Screening';
        if ($session->status === SessionStatus::EmergencyStopped) return 'Darurat';
        if (in_array($session->depression_level, [DepressionLevel::Berat, DepressionLevel::Sedang])) {
            return 'Perlu Perhatian';
        }
        return 'Stabil';
    }
}
