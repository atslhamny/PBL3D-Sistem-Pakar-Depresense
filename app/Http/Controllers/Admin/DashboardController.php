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
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_screenings' => ScreeningSession::count(),
            'emergency_cases' => ScreeningSession::emergency()->count(),
        ];
        
        $levelDistribution = ScreeningSession::where('status', 'completed')
            ->select('depression_level', DB::raw('count(*) as count'))
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
