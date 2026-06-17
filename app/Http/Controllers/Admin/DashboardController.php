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
        // ── 1. Basis penghitungan real dari DB ──────────────────────────────
        $realUsers      = User::where('role', 'user')->count();
        $realScreenings = ScreeningSession::count();
        $realEmergency  = ScreeningSession::emergency()->count();

        // Hanya sesi selesai (completed) yang relevan untuk distribusi tingkat
        $completedSessions = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)->count();

        $realMinimal = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->where('depression_level', \App\Enums\DepressionLevel::Minimal)->count();

        $realRingan  = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->where('depression_level', \App\Enums\DepressionLevel::Ringan)->count();

        $realSedang  = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->where('depression_level', \App\Enums\DepressionLevel::Sedang)->count();

        $realBerat   = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->where('depression_level', \App\Enums\DepressionLevel::Berat)->count();

        // ── 2. Perubahan minggu ini vs. 7 hari lalu (untuk badge ↑/↓) ───────
        $thisWeekStart = now()->subDays(6)->startOfDay();
        $lastWeekStart = now()->subDays(13)->startOfDay();
        $lastWeekEnd   = now()->subDays(7)->endOfDay();

        $usersThisWeek = User::where('role', 'user')
            ->where('created_at', '>=', $thisWeekStart)->count();
        $usersLastWeek = User::where('role', 'user')
            ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        $screeningsThisWeek = ScreeningSession::where('created_at', '>=', $thisWeekStart)->count();
        $screeningsLastWeek = ScreeningSession::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        $beratThisWeek = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->where('depression_level', \App\Enums\DepressionLevel::Berat)
            ->where('created_at', '>=', $thisWeekStart)->count();
        $beratLastWeek = ScreeningSession::where('status', \App\Enums\SessionStatus::Completed)
            ->where('depression_level', \App\Enums\DepressionLevel::Berat)
            ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        // Helper closure: hitung selisih persentase antara dua periode
        $calcChange = fn($now, $prev) => $prev > 0 ? round((($now - $prev) / $prev) * 100) : ($now > 0 ? 100 : 0);

        $userChangePercent      = $calcChange($usersThisWeek, $usersLastWeek);
        $screeningChangePercent = $calcChange($screeningsThisWeek, $screeningsLastWeek);
        $beratChangePercent     = $calcChange($beratThisWeek, $beratLastWeek);

        // ── 3. Statistik cards ───────────────────────────────────────────────
        // Denominator persentase depresi tinggi: hanya sesi completed
        $high_dep_percent = $completedSessions > 0
            ? round(($realBerat / $completedSessions) * 100)
            : 0;

        $stats = [
            'total_users'               => $realUsers,
            'total_screenings'          => $realScreenings,
            'emergency_cases'           => $realEmergency,
            'high_depression_percentage'=> $high_dep_percent,
            // Badge perubahan (int, bisa negatif)
            'user_change'               => $userChangePercent,
            'screening_change'          => $screeningChangePercent,
            'berat_change'              => $beratChangePercent,
        ];

        // ── 4. Distribusi Chart Data (Bar Chart) — hanya completed ──────────
        $chartData = [
            'labels' => ['Minimal', 'Ringan', 'Sedang', 'Berat'],
            'data'   => [$realMinimal, $realRingan, $realSedang, $realBerat],
        ];

        // ── 5. Peringatan Sistem — dinamis berdasarkan kondisi real ──────────
        $warnings = [];
        if ($beratChangePercent > 0) {
            $warnings[] = "Kasus depresi berat meningkat {$beratChangePercent}% dibanding minggu lalu.";
        }
        if ($realEmergency > 0) {
            $warnings[] = "Terdapat {$realEmergency} sesi dengan indikasi darurat yang perlu ditindaklanjuti.";
        }
        if ($realSedang > 0 && $completedSessions > 0 && round(($realSedang / $completedSessions) * 100) >= 30) {
            $warnings[] = "Lebih dari 30% pengguna berada di tingkat depresi sedang.";
        }
        // Fallback jika tidak ada peringatan nyata
        if (empty($warnings)) {
            $warnings[] = "Tidak ada peringatan kritis saat ini. Pantau secara berkala.";
        }

        // ── 6. Insight Utama — dinamis dari data real ────────────────────────
        $dominantLevel = 'minimal';
        $dominantCount = $realMinimal;
        foreach (['ringan' => $realRingan, 'sedang' => $realSedang, 'berat' => $realBerat] as $lvl => $cnt) {
            if ($cnt > $dominantCount) { $dominantCount = $cnt; $dominantLevel = $lvl; }
        }

        $insights = [];
        if ($completedSessions > 0) {
            $insights[] = [
                'type'    => 'neutral',
                'message' => "Mayoritas pengguna memiliki tingkat indikasi depresi <strong class=\"text-[#0d7a70]\">{$dominantLevel}</strong> "
                           . "({$dominantCount} dari {$completedSessions} sesi selesai).",
            ];
        }
        if ($beratChangePercent > 0) {
            $insights[] = [
                'type'    => 'warning',
                'message' => "Terjadi <strong class=\"text-[#b91c1c]\">peningkatan {$beratChangePercent}%</strong> pada kategori depresi berat minggu ini.",
            ];
        } elseif ($beratChangePercent < 0) {
            $absChange = abs($beratChangePercent);
            $insights[] = [
                'type'    => 'good',
                'message' => "Kasus depresi berat <strong class=\"text-emerald-600\">turun {$absChange}%</strong> dibanding minggu lalu.",
            ];
        } else {
            $insights[] = [
                'type'    => 'neutral',
                'message' => "Tingkat kasus depresi berat <strong class=\"text-slate-600\">stabil</strong> dibanding minggu lalu.",
            ];
        }

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

        return view('admin.dashboard', compact(
            'stats', 'chartData', 'trendData',
            'attentionUsers', 'recentActivities',
            'filter', 'warnings', 'insights'
        ));
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
