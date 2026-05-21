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
            ->count() + $realEmergency;

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
        
        // 4. Tren Chart Data (Line Chart) - 100% connected to DB
        $trendData = [
            'labels' => [],
            'ringan' => array_fill(0, 7, 0),
            'sedang' => array_fill(0, 7, 0),
            'berat' => array_fill(0, 7, 0)
        ];

        // Generate Indonesian day names for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayName = $date->locale('id')->dayName;
            $trendData['labels'][] = ucfirst($dayName);
        }

        // Query real database records from the last 7 days and add them to the trend data
        $sessionsLast7Days = ScreeningSession::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->get();

        foreach ($sessionsLast7Days as $session) {
            $dayIndex = 6 - now()->diffInDays($session->created_at);
            if ($dayIndex >= 0 && $dayIndex <= 6) {
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
                    'name' => $session->user->name ?? 'Pengguna Anonim',
                    'nim' => $session->user->nim ?? 'NIM tidak diset',
                    'score' => $scoreStr,
                    'level' => $levelStr,
                    'status' => $session->status === \App\Enums\SessionStatus::EmergencyStopped ? 'Memburuk' : ($session->score_total > 15 ? 'Meningkat' : 'Stabil')
                ];
            });

        // 6. Aktivitas Terbaru (100% DB-connected)
        $recentActivities = \App\Models\AuditLog::with('admin')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($log) {
                return [
                    'time' => $log->created_at->format('h:i A'),
                    'activity' => $log->action === 'POST' ? 'Menambahkan Data' : ($log->action === 'DELETE' ? 'Menghapus Data' : 'Mengubah Aturan R' . sprintf('%03d', $log->entity_id)),
                    'user' => $log->admin->name ?? 'Admin'
                ];
            });

        return view('admin.dashboard', compact('stats', 'chartData', 'trendData', 'attentionUsers', 'recentActivities'));
    }

    public function downloadExcel()
    {
        $stats = [
            'Total Pengguna' => User::where('role', 'user')->count(),
            'Total Penilaian' => ScreeningSession::count(),
            'Kasus Depresi Tinggi' => ScreeningSession::emergency()->count(),
        ];

        $levelDistribution = ScreeningSession::where('status', 'completed')
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
