<x-admin-layout title="Dashboard">
    <!-- Header Page -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Dashboard Ikhtisar</h2>
            <p class="text-slate-500 mt-1">Pantauan sistem dan penilaian DepreSense.</p>
        </div>
        <button class="flex items-center px-4 py-2 bg-[#0d7a70] text-white text-sm font-semibold rounded-lg hover:bg-[#0a635b] transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Unduh Laporan
        </button>
    </div>

    <!-- Alert Box (Opsional, sesuai gambar) -->
    @if($stats['emergency_cases'] > 0)
    <div class="mb-8 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start">
        <div class="bg-rose-100 p-2 rounded-lg mr-4">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <h4 class="text-sm font-bold text-rose-800">Peringatan Sistem</h4>
            <p class="text-xs text-rose-700 mt-1">Terdapat {{ $stats['emergency_cases'] }} kasus indikasi depresi berat yang memerlukan perhatian segera.</p>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Pengguna -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center">
            <div class="bg-emerald-50 p-4 rounded-2xl mr-5">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pengguna</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total_users']) }}</h3>
            </div>
        </div>

        <!-- Total Assessment -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center">
            <div class="bg-blue-50 p-4 rounded-2xl mr-5">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Penilaian</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total_screenings']) }}</h3>
            </div>
        </div>

        <!-- Emergency Cases -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center">
            <div class="bg-rose-50 p-4 rounded-2xl mr-5">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Depresi Tinggi</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['emergency_cases'] }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart Section -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Distribusi Tingkat Depresi</h3>
                <span class="text-xs font-medium text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">Live Data</span>
            </div>
            <div class="relative h-[300px]">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Akses Cepat</h3>
            <div class="space-y-4">
                <a href="{{ route('admin.questions.index') }}" class="group flex items-center p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-[#0d7a70] hover:bg-white transition-all">
                    <div class="bg-white group-hover:bg-[#ecf5f4] p-3 rounded-xl mr-4 shadow-sm transition-colors">
                        <svg class="w-5 h-5 text-[#0d7a70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Kelola Pertanyaan</span>
                </a>

                <a href="{{ route('admin.fuzzy-rules.index') }}" class="group flex items-center p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-[#0d7a70] hover:bg-white transition-all">
                    <div class="bg-white group-hover:bg-[#ecf5f4] p-3 rounded-xl mr-4 shadow-sm transition-colors">
                        <svg class="w-5 h-5 text-[#0d7a70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.675.337a4 4 0 01-2.58.344l-1.787-.357a2 2 0 00-1.872.63L4 16.5m15.428-1.072l1.072 1.072m0 0l1.414 1.414M4 16.5l-1.5 1.5M4 16.5l1.5 1.5m1.072-1.072L5.5 17.5"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Aturan Logika Fuzzy</span>
                </a>

                <a href="{{ route('admin.audit-logs.index') }}" class="group flex items-center p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-[#0d7a70] hover:bg-white transition-all">
                    <div class="bg-white group-hover:bg-[#ecf5f4] p-3 rounded-xl mr-4 shadow-sm transition-colors">
                        <svg class="w-5 h-5 text-[#0d7a70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Log Aktivitas Sistem</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Chart Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('distributionChart');
            if(ctx) {
                new Chart(ctx, {
                    type: 'bar', // Mengubah ke Bar Chart agar mirip dengan gambar referensi
                    data: {
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [{
                            label: 'Jumlah Kasus',
                            data: {!! json_encode($chartData['data']) !!},
                            backgroundColor: [
                                '#72d392', // Emerald/Hijau Muda
                                '#a5b4fc', // Indigo/Blue Soft
                                '#fb923c', // Orange
                                '#fda4af', // Rose/Red Soft
                            ],
                            borderRadius: 8,
                            barThickness: 40,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: { display: false }, border: { display: false } },
                            x: { grid: { display: false }, border: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
</x-admin-layout>