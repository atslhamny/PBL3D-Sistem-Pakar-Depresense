<x-admin-layout title="Dashboard">
    <!-- Header Page & Download Dropdown -->
    <div class="flex justify-between items-center mb-8 print:hidden">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Dashboard</h2>
            <p class="text-slate-500 mt-1">Pantauan sistem dan penilaian DepreSense.</p>
        </div>
        
        <!-- Dropdown Fitur Unduh (Alpine.js) -->
        <div x-data="{ open: false }" @click.away="open = false" class="relative">
            <button @click="open = !open" class="flex items-center px-4 py-2 bg-[#0d7a70] text-white text-sm font-semibold rounded-lg hover:bg-[#0a635b] transition-colors shadow-sm focus:outline-none">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh Laporan
                <svg class="w-4 h-4 ml-2 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg z-50 py-1">
                <!-- Pilihan PDF -->
                <button onclick="window.print()" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium">
                    <svg class="w-4 h-4 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Simpan sebagai PDF
                </button>
                <!-- Pilihan Excel -->
                <a href="{{ route('admin.dashboard.download-excel') }}" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium">
                    <svg class="w-4 h-4 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Unduh Excel (.csv)
                </a>
            </div>
        </div>
    </div>

    <!-- Teks header rapi khusus cetak PDF -->
    <div class="hidden print:block mb-8 border-b pb-4">
        <h1 class="text-3xl font-black text-slate-900">LAPORAN MONITORING DEPRESENSE</h1>
        <p class="text-sm text-slate-600 mt-1">Dicetak otomatis oleh sistem pada: {{ date('d M Y, H:i') }}</p>
    </div>

    <!-- Alert Box -->
    @if($stats['emergency_cases'] > 0)
    <div class="mb-8 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start break-inside-avoid">
        <div class="bg-rose-100 p-2 rounded-lg mr-4 print:hidden">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <h4 class="text-sm font-bold text-rose-800">Peringatan Sistem</h4>
            <p class="text-xs text-rose-700 mt-1">Terdapat {{ $stats['emergency_cases'] }} kasus indikasi depresi berat yang memerlukan perhatian segera.</p>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 print:grid-cols-3">
        <!-- Total Pengguna -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center break-inside-avoid">
            <div class="bg-emerald-50 p-4 rounded-2xl mr-5 print:hidden">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pengguna</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total_users']) }}</h3>
            </div>
        </div>

        <!-- Total Assessment -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center break-inside-avoid">
            <div class="bg-blue-50 p-4 rounded-2xl mr-5 print:hidden">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Penilaian</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total_screenings']) }}</h3>
            </div>
        </div>

        <!-- Emergency Cases -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center break-inside-avoid">
            <div class="bg-rose-50 p-4 rounded-2xl mr-5 print:hidden">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Depresi Tinggi</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['emergency_cases'] }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 print:block">
        <!-- Chart Section -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm break-inside-avoid">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Distribusi Tingkat Depresi</h3>
                <span class="text-xs font-medium text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100 print:hidden">Live Data</span>
            </div>
            <div class="relative h-[300px]">
                <canvas id="distributionChart" 
                        data-labels="{{ json_encode($chartData['labels']) }}"
                        data-values="{{ json_encode($chartData['data']) }}">
                </canvas>
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
            const ctx = document.getElementById('distributionChart');
            if (ctx) {
                const chartLabels = JSON.parse(ctx.getAttribute('data-labels'));
                const chartValues = JSON.parse(ctx.getAttribute('data-values'));

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Jumlah Kasus',
                            data: chartValues,
                            backgroundColor: [
                                '#72d392', // Emerald
                                '#a5b4fc', // Indigo
                                '#fb923c', // Orange
                                '#fda4af', // Rose
                            ],
                            borderRadius: 8,
                            barThickness: 40,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: false, // Dimatikan agar grafik instan ter-render penuh saat cetak PDF
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