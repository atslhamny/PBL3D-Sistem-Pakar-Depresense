<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScreeningSession;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Real database counts
        $realUsers = User::where('role', 'user')->count();
        $realScreenings = ScreeningSession::count();
        $realEmergency = ScreeningSession::emergency()->count();
        
        $realRingan = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->whereIn('depression_level', [\App\Enums\DepressionLevel::Ringan, \App\Enums\DepressionLevel::Minimal])
            ->count();
            
        $realSedang = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->where('depression_level', \App\Enums\DepressionLevel::Sedang)
            ->count();
            
        $realBerat = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->where('depression_level', \App\Enums\DepressionLevel::Berat)
            ->count();

        // 2. High-fidelity statistics (Real Database only)
        $total_users = $realUsers;
        $total_screenings = $realScreenings;
        $high_dep_percent = $total_screenings > 0 ? round(($realBerat / $total_screenings) * 100) : 0;

        $stats = [
            'total_users' => $total_users,
            'total_screenings' => $total_screenings,
            'emergency_cases' => $realEmergency,
            'high_depression_percentage' => $high_dep_percent
        ];
        
        // 3. Distribusi Chart Data (Bar Chart) - 100% connected to DB
        $chartData = [
            'labels' => ['Ringan', 'Sedang', 'Berat'],
            'data' => [
                $realRingan,
                $realSedang,
                $realBerat
            ]
        ];
        
        $filter = (int) request()->query('filter', 7);
        if (!in_array($filter, [7, 14, 30])) {
            $filter = 7;
        }

        // 4. Tren Chart Data (Line Chart) - 100% connected to DB
        $trendData = [
            'labels' => [],
            'ringan' => array_fill(0, $filter, 0),
            'sedang' => array_fill(0, $filter, 0),
            'berat' => array_fill(0, $filter, 0)
        ];

        // Generate Indonesian day names/dates for the last $filter days
        for ($i = $filter - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            if ($filter === 7) {
                $trendData['labels'][] = ucfirst($date->locale('id')->dayName);
            } else {
                $trendData['labels'][] = $date->format('d M');
            }
        }

        // Query real database records from the last $filter days and add them to the trend data
        $sessionsLastXDays = ScreeningSession::where('created_at', '>=', now()->subDays($filter - 1)->startOfDay())
            ->get();

        foreach ($sessionsLastXDays as $session) {
            $dayIndex = ($filter - 1) - now()->startOfDay()->diffInDays($session->created_at->startOfDay());
            if ($dayIndex >= 0 && $dayIndex < $filter) {
                if ($session->status === \App\Enums\SessionStatus::EmergencyStopped || $session->depression_level === \App\Enums\DepressionLevel::Berat) {
                    $trendData['berat'][$dayIndex]++;
                } elseif ($session->depression_level === \App\Enums\DepressionLevel::Sedang) {
                    $trendData['sedang'][$dayIndex]++;
                } elseif ($session->depression_level === \App\Enums\DepressionLevel::Ringan || $session->depression_level === \App\Enums\DepressionLevel::Minimal) {
                    $trendData['ringan'][$dayIndex]++;
                }
            }
        }

        // 5. Pengguna Perlu Perhatian (100% DB-connected)
        $attentionUsers = ScreeningSession::with('user')
            ->where(function($query) {
                $query->whereIn('depression_level', [\App\Enums\DepressionLevel::Berat, \App\Enums\DepressionLevel::Sedang])
                      ->orWhere('status', \App\Enums\SessionStatus::EmergencyStopped);
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($session) {
                $levelStr = $session->depression_level ? ucfirst($session->depression_level->value) : 'Berat (Kritis)';
                $scoreStr = $session->score_total !== null ? $session->score_total : 'Kritis';
                return [
                    'name'       => $session->user?->name ?? 'Pengguna Anonim',
                    'university' => $session->user?->university ?? 'Universitas tidak diset',
                    'score'      => $scoreStr,
                    'level'      => $levelStr,
                    'status'     => $session->status === \App\Enums\SessionStatus::EmergencyStopped
                                        ? 'Memburuk'
                                        : ($session->score_total > 15 ? 'Meningkat' : 'Stabil')
                ];
            });

        // 6. Aktivitas Terbaru (100% DB-connected)
        $recentActivities = \App\Models\ScreeningSession::with('user')
            ->whereIn('status', [\App\Enums\SessionStatus::Completed, \App\Enums\SessionStatus::EmergencyStopped])
            ->orderBy('completed_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($session) {
                return [
                    'time' => $session->completed_at ? $session->completed_at->timezone(config('app.timezone'))->format('H:i') : '-',
                    'activity' => 'Menyelesaikan Skrining (Skor: ' . ($session->score_total ?? '-') . ')',
                    'user' => $session->user ? $session->user->full_name : 'Guest (Anonim)'
                ];
            });

        return view('admin.dashboard', compact('stats', 'chartData', 'trendData', 'attentionUsers', 'recentActivities', 'filter'));
    }

    public function downloadExcel()
    {
        $stats = [
            'Total Pengguna' => User::where('role', 'user')->count(),
            'Total Penilaian' => ScreeningSession::count(),
            'Kasus Depresi Tinggi' => ScreeningSession::emergency()->count(),
        ];

        $levelDistribution = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->select('depression_level', DB::raw('count(*) as count'))
            ->groupBy('depression_level')
            ->pluck('count', 'depression_level')
            ->toArray();

        $fileName = 'Laporan_Ikhtisar_DepreSense_' . date('Y-m-d') . '.xls';

        // Headers menggunakan tipe data excel standar umum
        $headers = [
            "Content-type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($stats, $levelDistribution) {
            // Menggunakan format HTML khusus yang kompatibel dengan parser Microsoft Excel
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head>';
            echo '<meta http-equiv="Content-type" content="text/html;charset=utf-8" />';
            echo '';
            
            // CSS Style bawaan untuk mengatur lebar otomatis (mso-number-format) dan warna
            echo '<style>';
            echo '  .title { font-family: sans-serif; font-size: 14pt; font-weight: bold; height: 35px; }';
            echo '  .meta-text { font-family: sans-serif; font-size: 10pt; color: #475569; }';
            echo '  .th-header { font-family: sans-serif; font-size: 11pt; font-weight: bold; background-color: #E2E8F0; text-align: left; border: 0.5pt solid #CBD5E1; }';
            echo '  .td-data { font-family: sans-serif; font-size: 10pt; border: 0.5pt solid #E2E8F0; }';
            echo '  /* KUNCI AUTOMATIS LEBAR: Memaksa Excel menyesuaikan panjang teks */';
            echo '  td, th { white-space: nowrap !important; }'; 
            echo '</style>';
            echo '</head>';
            echo '<body>';

            echo '<table>';
            
            // Judul Utama
            echo '  <tr><td colspan="2" class="title">LAPORAN IKHTISAR SISTEM DEPRESENSE</td></tr>';
            echo '  <tr><td class="meta-text"><b>Tanggal Cetak:</b></td><td class="meta-text">' . date('Y-m-d H:i:s') . '</td></tr>';
            echo '  <tr><td></td><td></td></tr>'; // Jeda baris kosong

            // Blok 1: Metrik Utama
            echo '  <tr><th class="th-header" style="width: 250px;">METRIK UTAMA</th><th class="th-header" style="width: 120px;">JUMLAH KASUS</th></tr>';
            foreach ($stats as $key => $value) {
                echo '  <tr><td class="td-data">' . $key . '</td><td class="td-data" align="right">' . $value . '</td></tr>';
            }
            echo '  <tr><td></td><td></td></tr>'; // Jeda baris kosong

            // Blok 2: Distribusi Tingkat Depresi
            echo '  <tr><th class="th-header">TINGKAT DEPRESI</th><th class="th-header">TOTAL DATA</th></tr>';
            $levels = [
                'Minimal' => $levelDistribution['minimal'] ?? 0,
                'Ringan'  => $levelDistribution['ringan'] ?? 0,
                'Sedang'  => $levelDistribution['sedang'] ?? 0,
                'Berat'   => $levelDistribution['berat'] ?? 0,
            ];
            foreach ($levels as $level => $count) {
                echo '  <tr><td class="td-data">' . $level . '</td><td class="td-data" align="right">' . $count . '</td></tr>';
            }

            echo '</table>';
            echo '</body>';
            echo '</html>';
        };

        return response()->stream($callback, 200, $headers);
    }
}
