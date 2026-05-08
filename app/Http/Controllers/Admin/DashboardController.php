<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScreeningSession;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_screenings' => ScreeningSession::count(),
            'emergency_cases' => ScreeningSession::emergency()->count(),
        ];
        
        $levelDistribution = ScreeningSession::where('status', 'completed')
            ->select('depression_level', \DB::raw('count(*) as count'))
            ->groupBy('depression_level')
            ->pluck('count', 'depression_level')
            ->toArray();

        $chartData = [
            'labels' => ['Minimal', 'Ringan', 'Sedang', 'Berat'],
            'data' => [
                $levelDistribution['minimal'] ?? 0,
                $levelDistribution['ringan'] ?? 0,
                $levelDistribution['sedang'] ?? 0,
                $levelDistribution['berat'] ?? 0,
            ]
        ];
        
        return view('admin.dashboard', compact('stats', 'chartData'));
    }
}
