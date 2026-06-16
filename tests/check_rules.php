<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== AUDIT BUG SISI USER ===\n\n";

// 1. Periksa jumlah aturan aktif
$activeRules = App\Models\FuzzyRule::where('is_active', true)->count();
$totalRules = App\Models\FuzzyRule::count();
echo "[1] Jumlah Aturan: {$activeRules} aktif dari {$totalRules} total. ";
echo ($activeRules === 16) ? "✓ BENAR (16 sesuai arsitektur 2-input)\n" : "✗ SALAH! (seharusnya 16)\n";

// 2. Periksa parameter membership
$vars = App\Models\FuzzyMembershipParam::distinct('variable_name')->pluck('variable_name');
echo "[2] Variabel Membership: " . $vars->join(', ') . "\n";
echo "    Total records: " . App\Models\FuzzyMembershipParam::count() . " (seharusnya 12: 3 variabel × 4 himpunan) ";
echo (App\Models\FuzzyMembershipParam::count() === 12) ? "✓\n" : "✗\n";

// 3. Periksa output fuzzy untuk berbagai skenario
echo "\n[3] Uji Output Fuzzy:\n";
$engine = app(App\Fuzzy\FuzzyEngine::class);
$tests = [
    ['Minimal (Kog:2, Som:1)',  2,  1, 'minimal'],
    ['Ringan  (Kog:10, Som:7)', 10, 7, 'ringan'],
    ['Sedang  (Kog:13, Som:8)', 13, 8, 'sedang'],
    ['Berat   (Kog:25, Som:16)',25, 16,'berat'],
];
foreach ($tests as [$label, $k, $s, $exp]) {
    $result = $engine->run(new App\Fuzzy\DTOs\FuzzyInput($k, $s));
    $ok = $result->depressionLevel->value === $exp ? '✓' : '✗';
    echo "    [{$ok}] {$label} → Centroid:{$result->centroid}, Level:{$result->depressionLevel->value}\n";
}

// 4. Periksa sesi yang menggantung (in_progress > 30 menit)
$stuckSessions = App\Models\ScreeningSession::where('status', 'in_progress')
    ->where('informed_consent_at', '<', now()->subMinutes(30))
    ->count();
echo "\n[4] Sesi InProgress menggantung (>30 menit): {$stuckSessions} sesi. ";
echo ($stuckSessions === 0) ? "✓\n" : "⚠ Ada {$stuckSessions} sesi yang belum di-expire\n";

// 5. Periksa sesi completed tanpa centroid (centroid = 0.00 atau null)
$zeroCentroid = App\Models\ScreeningSession::where('status', 'completed')
    ->where(function($q) {
        $q->whereNull('fuzzy_centroid_value')
          ->orWhere('fuzzy_centroid_value', 0.00);
    })->count();
echo "[5] Sesi Completed dengan centroid 0.00/null: {$zeroCentroid}. ";
echo ($zeroCentroid === 0) ? "✓ Tidak ada\n" : "⚠ Ada {$zeroCentroid} sesi dengan kalkulasi gagal (data lama)\n";

// 6. Periksa apakah ada pertanyaan yang tidak terisi kategori
$uncatQs = App\Models\BdiQuestion::whereNull('category')->count();
echo "[6] Pertanyaan tanpa kategori: {$uncatQs}. ";
echo ($uncatQs === 0) ? "✓\n" : "✗ Ada {$uncatQs} pertanyaan tanpa kategori (akan merusak scoring)\n";

// 7. Total pertanyaan
$qCount = App\Models\BdiQuestion::count();
echo "[7] Jumlah Pertanyaan BDI-II: {$qCount}. ";
echo ($qCount === 21) ? "✓ Lengkap 21 pertanyaan\n" : "✗ Seharusnya 21, ditemukan {$qCount}\n";

echo "\n=== SELESAI ===\n";
