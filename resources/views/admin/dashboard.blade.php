<x-admin-layout title="Dashboard Ikhtisar">
    <!-- Dashboard Wrapper -->
    <div class="flex flex-col font-sans">
        
        <!-- Header Page & Download Dropdown -->
        <div class="flex justify-between items-center mb-8 print:hidden">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Ikhtisar</h2>
                <p class="text-slate-500 mt-1 font-medium text-sm">Pantauan sistem dan penilaian DepreSense.</p>
            </div>
            
            <!-- Dropdown Fitur Unduh (Alpine.js) -->
            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                <button @click="open = !open" class="flex items-center px-5 py-2.5 bg-[#0d7a70] text-white text-sm font-semibold rounded-xl hover:bg-[#0a635b] transition-colors shadow-sm focus:outline-none">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Unduh Laporan
                    <svg class="w-4 h-4 ml-2 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg z-50 py-1" style="display: none;">
                    <!-- Pilihan PDF -->
                    <button onclick="window.print()" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-semibold">
                        <svg class="w-4 h-4 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Simpan sebagai PDF
                    </button>
                    <!-- Pilihan Excel -->
                    <a href="{{ route('admin.dashboard.download-excel') }}" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-semibold">
                        <svg class="w-4 h-4 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Unduh Excel (.xls)
                    </a>
                </div>
            </div>
        </div>

        <div class="hidden print:block mb-8 border-b pb-4 text-slate-900">
            <h1 class="text-2xl font-bold">LAPORAN MONITORING DEPRESENSE</h1>
            <p class="text-sm text-slate-600 mt-1">Dicetak otomatis oleh sistem pada: {{ date('d M Y, H:i') }}</p>
        </div>

        <!-- Peringatan Sistem Box -->
        <div class="mb-8 p-5 bg-[#fdf2f2] border border-[#f5c6cb]/40 rounded-2xl flex items-start break-inside-avoid shadow-sm text-slate-800">
            <div class="bg-rose-100 p-3 rounded-2xl mr-4 text-[#b91c1c] print:hidden flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-[#b91c1c] flex items-center gap-1.5 uppercase tracking-wider">Peringatan Sistem</h4>
                <ul class="text-xs text-[#b91c1c] mt-1.5 space-y-1.5 font-semibold">
                    <li class="flex items-center"><span class="h-1.5 w-1.5 bg-[#b91c1c] rounded-full mr-2"></span>Jumlah depresi berat meningkat minggu ini</li>
                    <li class="flex items-center"><span class="h-1.5 w-1.5 bg-[#b91c1c] rounded-full mr-2"></span>Beberapa pengguna menunjukkan tren memburuk</li>
                </ul>
            </div>
        </div>

        <!-- Stats Cards (Grid 3 Columns) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 print:grid-cols-3">
            <!-- Total Pengguna -->
            <div class="bg-white text-slate-800 p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden break-inside-avoid group hover:shadow-md transition-all duration-300">
                <div class="flex items-center z-10">
                    <div class="bg-emerald-50 p-4 rounded-2xl mr-5 text-emerald-600 print:hidden flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pengguna</p>
                        <h3 class="text-2xl font-bold text-[#0d7a70] mt-1.5 flex items-center gap-2">
                            {{ number_format($stats['total_users']) }}
                            <span class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-100">↑12%</span>
                        </h3>
                        <p class="text-[10px] text-slate-400 mt-2 font-semibold">dibandingkan periode sebelumnya</p>
                    </div>
                </div>
                <!-- Faint Silhouette Background Icon -->
                <div class="absolute -right-5 -bottom-5 text-slate-950 opacity-[0.03] group-hover:scale-110 transition-transform duration-300 pointer-events-none">
                    <svg class="w-28 h-28" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Penilaian -->
            <div class="bg-white text-slate-800 p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden break-inside-avoid group hover:shadow-md transition-all duration-300">
                <div class="flex items-center z-10">
                    <div class="bg-[#ecf5f4] p-4 rounded-2xl mr-5 text-[#0d7a70] print:hidden flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Penilaian</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1.5 flex items-center gap-2">
                            {{ number_format($stats['total_screenings']) }}
                            <span class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-100">↑8%</span>
                        </h3>
                        <p class="text-[10px] text-slate-400 mt-2 font-semibold">dibandingkan periode sebelumnya</p>
                    </div>
                </div>
                <!-- Faint Silhouette Background Icon -->
                <div class="absolute -right-5 -bottom-5 text-slate-950 opacity-[0.03] group-hover:scale-110 transition-transform duration-300 pointer-events-none">
                    <svg class="w-28 h-28" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path>
                    </svg>
                </div>
            </div>

            <!-- Persentase Depresi Tinggi -->
            <div class="bg-white text-slate-800 p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden break-inside-avoid group hover:shadow-md transition-all duration-300">
                <div class="flex items-center z-10">
                    <div class="bg-rose-50 p-4 rounded-2xl mr-5 text-rose-500 print:hidden flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Persentase Depresi Tinggi</p>
                        <h3 class="text-2xl font-bold text-rose-600 mt-1.5 flex items-center gap-2">
                            {{ $stats['high_depression_percentage'] }}%
                            <span class="text-rose-500 text-xs font-bold flex items-center bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-100">↑2%</span>
                        </h3>
                        <p class="text-[10px] text-slate-400 mt-2 font-semibold">dibandingkan periode sebelumnya</p>
                    </div>
                </div>
                <!-- Faint Silhouette Background Icon -->
                <div class="absolute -right-5 -bottom-5 text-slate-950 opacity-[0.03] group-hover:scale-110 transition-transform duration-300 pointer-events-none">
                    <svg class="w-28 h-28" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Charts Row (Tren & Distribusi) -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8 print:block">
            <!-- Tren Tingkat Depresi (Line Chart) -->
            <div class="lg:col-span-3 bg-white text-slate-800 p-8 rounded-[2rem] border border-slate-200 shadow-sm break-inside-avoid">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 tracking-tight">Tren Tingkat Depresi</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Grafik Garis: Tren Ringan, Sedang, Berat</p>
                    </div>
                    <div x-data="{ open: false }" class="relative print:hidden">
                        <button @click="open = !open" class="flex items-center px-4 py-2 bg-slate-50 border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-100 transition-colors focus:outline-none shadow-sm">
                            {{ $filter }} Hari
                            <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-32 bg-white border border-slate-100 rounded-xl shadow-lg z-50 py-1" style="display: none;">
                            <a href="{{ route('admin.dashboard', ['filter' => 7]) }}" class="block w-full text-left px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 font-semibold {{ $filter == 7 ? 'text-[#0d7a70] bg-[#ecf5f4]' : '' }}">7 Hari</a>
                            <a href="{{ route('admin.dashboard', ['filter' => 14]) }}" class="block w-full text-left px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 font-semibold {{ $filter == 14 ? 'text-[#0d7a70] bg-[#ecf5f4]' : '' }}">14 Hari</a>
                            <a href="{{ route('admin.dashboard', ['filter' => 30]) }}" class="block w-full text-left px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 font-semibold {{ $filter == 30 ? 'text-[#0d7a70] bg-[#ecf5f4]' : '' }}">30 Hari</a>
                        </div>
                    </div>
                </div>
                <div class="relative h-[280px]">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Distribusi Tingkat Depresi (Bar Chart) -->
            <div class="lg:col-span-2 bg-white text-slate-800 p-8 rounded-[2rem] border border-slate-200 shadow-sm break-inside-avoid flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Distribusi Tingkat Depresi</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Live data dari total sesi penilaian mahasiswa</p>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 bg-slate-50 px-2.5 py-1 rounded-full border border-slate-100 uppercase tracking-wider print:hidden">Live Data</span>
                    </div>
                    <div class="relative h-[250px]">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
                <!-- Custom Horizontal Legend below the Bar Chart -->
                <div class="flex justify-center items-center gap-6 mt-4 text-xs font-semibold text-slate-500">
                    <span class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 bg-[#72d392] rounded"></span>
                        Ringan
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 bg-[#cbd5e1] rounded"></span>
                        Sedang
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 bg-[#fda4af] rounded"></span>
                        Berat
                    </span>
                </div>
            </div>
        </div>

        <!-- Insight & Attention Row (Stacked Vertically for Perfect Visual Space) -->
        <div class="flex flex-col gap-6 mb-8">
            <!-- Insight Utama -->
            <div class="bg-white text-slate-800 p-8 rounded-[2rem] border border-slate-200 shadow-sm flex flex-col justify-between break-inside-avoid">
                <div>
                    <h3 class="text-xl font-bold text-slate-850 tracking-tight">Insight Utama</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Analisis instan sistem diagnosis</p>
                </div>
                
                <div class="my-6 space-y-3">
                    <!-- Bar 1 (White rounded bar matching screenshot) -->
                    <div class="bg-white border border-slate-200/60 px-5 py-3.5 rounded-2xl shadow-sm text-sm font-medium text-slate-700 w-full">
                        Mayoritas pengguna mengalami gejala utama pada kategori <span class="text-[#0d7a70] font-bold">emosi</span>.
                    </div>
                    
                    <!-- Bar 2 (Soft light yellow rounded bar matching screenshot) -->
                    <div class="bg-[#fffcf4] border border-[#f1e7bc]/60 px-5 py-3.5 rounded-2xl shadow-sm text-sm font-medium text-slate-700 w-full">
                        Terjadi <span class="text-[#b91c1c] font-bold">peningkatan</span> pada kategori tingkat depresi sedang.
                    </div>
                </div>

                <div class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-2">
                    REKOMENDASI TINDAKAN TERKIRIM OTOMATIS
                </div>
            </div>

            <!-- Pengguna Perlu Perhatian -->
            <div class="bg-white text-slate-800 p-8 rounded-[2rem] border border-slate-200 shadow-sm break-inside-avoid">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-slate-850 tracking-tight">Pengguna Perlu Perhatian</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar pengguna dengan skor asesmen kritis terdeteksi</p>
                    </div>
                    <span class="text-[10px] font-bold text-rose-500 bg-rose-50 px-3.5 py-1.5 rounded-full border border-rose-100 uppercase tracking-wider">Segera Tangani</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                                <th class="pb-3 text-slate-400 font-bold">NAMA/UNIVERSITAS</th>
                                <th class="pb-3 text-slate-400 font-bold">SKOR TERAKHIR</th>
                                <th class="pb-3 text-slate-400 font-bold w-36 text-right">STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-xs">
                            @foreach($attentionUsers as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <!-- Avatar Circle matching screenshot -->
                                            <div class="h-9 w-9 rounded-full bg-slate-50 border border-slate-200/80 font-bold text-[#0d7a70] text-sm flex items-center justify-center flex-shrink-0 shadow-sm">
                                                {{ substr($user['name'], 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800 text-sm">{{ $user['name'] }}</span>
                                                <span class="text-[10px] text-slate-400 mt-0.5 font-semibold">{{ $user['university'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700 text-sm">{{ $user['score'] }}</span>
                                            <span class="text-[10px] text-slate-400 mt-0.5 font-semibold">({{ $user['level'] }})</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-right">
                                        @if($user['status'] === 'Memburuk')
                                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100/60 shadow-sm">Memburuk</span>
                                        @elseif($user['status'] === 'Meningkat')
                                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100/60 shadow-sm">Meningkat</span>
                                        @else
                                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-50 text-slate-500 border border-slate-200/60 shadow-sm">Stabil</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Action Row (Stacked for beautiful horizontal layout) -->
        <div class="flex flex-col gap-6">
            <!-- Aktivitas Terbaru -->
            <div class="bg-white text-slate-800 p-8 rounded-[2rem] border border-slate-200 shadow-sm break-inside-avoid">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-slate-850 tracking-tight">Aktivitas Terbaru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Operasional sistem dan pendaftaran akun terkini</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                                <th class="pb-3 text-slate-400 font-bold w-36">WAKTU</th>
                                <th class="pb-3 text-slate-400 font-bold">AKTIVITAS</th>
                                <th class="pb-3 text-slate-400 font-bold w-48 text-right">PENGGUNA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-xs text-slate-700">
                            @foreach($recentActivities as $act)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 text-slate-400 font-semibold">{{ $act['time'] }}</td>
                                    <td class="py-4 font-bold text-slate-800 text-sm">{{ $act['activity'] }}</td>
                                    <td class="py-4 font-semibold text-slate-500 text-right">{{ $act['user'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>

    </div>

    <!-- Tambahan Utility CSS Khusus Cetak PDF -->
    <style>
        @media print {
            body { background: white !important; color: black !important; }
            .print\:hidden { display: none !important; }
            .print\:block { display: block !important; }
            .print\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)) !important; }
            .break-inside-avoid { break-inside: avoid !important; page-break-inside: avoid !important; }
        }
    </style>

    <!-- Chart Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Line Chart (Tren Tingkat Depresi)
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                const trendLabels = @json($trendData['labels']);
                const dataRingan = @json($trendData['ringan']);
                const dataSedang = @json($trendData['sedang']);
                const dataBerat = @json($trendData['berat']);

                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: trendLabels,
                        datasets: [
                            {
                                label: 'Ringan',
                                data: dataRingan,
                                borderColor: '#72d392', // Emerald
                                backgroundColor: 'rgba(114, 211, 146, 0.04)',
                                borderWidth: 3.5,
                                tension: 0.35,
                                fill: true,
                                pointRadius: 2,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Sedang',
                                data: dataSedang,
                                borderColor: '#cbd5e1', // Gray/Slate (matches screenshot)
                                backgroundColor: 'rgba(203, 213, 225, 0.04)',
                                borderWidth: 3.5,
                                tension: 0.35,
                                fill: true,
                                pointRadius: 2,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Berat',
                                data: dataBerat,
                                borderColor: '#fda4af', // Rose
                                backgroundColor: 'rgba(253, 164, 175, 0.04)',
                                borderWidth: 3.5,
                                tension: 0.35,
                                fill: true,
                                pointRadius: 2,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 15,
                                    font: { size: 11, weight: '600', family: 'Inter' }
                                }
                            }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                grid: { color: '#f8fafc', drawBorder: false }, 
                                ticks: { font: { size: 10, family: 'Inter' } } 
                            },
                            x: { 
                                grid: { display: false }, 
                                ticks: { font: { size: 10, family: 'Inter' } } 
                            }
                        }
                    }
                });
            }

            // 2. Bar Chart (Distribusi Tingkat Depresi)
            const distCtx = document.getElementById('distributionChart');
            if (distCtx) {
                const chartLabels = @json($chartData['labels']);
                const chartValues = @json($chartData['data']);

                new Chart(distCtx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Jumlah Kasus',
                            data: chartValues,
                            backgroundColor: [
                                '#72d392', // Emerald
                                '#cbd5e1', // Gray/Slate
                                '#fda4af', // Rose
                            ],
                            borderRadius: 12,
                            barThickness: 32,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true,
                                ticks: {
                                    font: { size: 10, family: 'Inter' }
                                },
                                grid: { color: '#f8fafc', drawBorder: false }
                            },
                            x: { 
                                grid: { display: false }, 
                                ticks: { font: { size: 10, family: 'Inter' } } 
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-admin-layout>