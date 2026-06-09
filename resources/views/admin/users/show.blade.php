<x-admin-layout>

    <x-slot name="title">Detail Pengguna - {{ $user->full_name }} | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

    {{-- Back Button + Header --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}"
               class="p-2.5 bg-white border border-slate-200 text-slate-500 hover:text-[#0d7a70] hover:border-[#0d7a70] rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Detail Pengguna</h2>
                <p class="text-sm text-slate-400 mt-0.5">Riwayat lengkap skrining dan profil mahasiswa</p>
            </div>
        </div>
        @php
            $badgeClass = match($userStatus) {
                'Darurat' => 'bg-rose-100 text-rose-700 border-rose-200',
                'Perlu Perhatian' => 'bg-amber-50 text-amber-700 border-amber-200',
                'Stabil' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                default => 'bg-blue-50 text-blue-600 border-blue-100'
            };
        @endphp
        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider border {{ $badgeClass }}">
            {{ $userStatus }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Profil Card --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Profile Card --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="h-20 w-20 rounded-full bg-[#ecf5f4] border-2 border-[#0d7a70]/20 text-[#0d7a70] font-black text-2xl flex items-center justify-center mb-4">
                        {{ strtoupper(substr($user->full_name, 0, 2)) }}
                    </div>
                    <h3 class="text-lg font-black text-slate-800">{{ $user->full_name }}</h3>
                    <p class="text-sm text-slate-400 mt-1">{{ $user->email }}</p>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Universitas</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $user->university ?? 'Tidak diisi' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Program Studi</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $user->study_program ?? 'Tidak diisi' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Semester</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $user->semester ? $user->semester . ' — ' . $user->semester : 'Tidak diisi' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Bergabung</span>
                        <span class="text-xs font-semibold text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Statistik Skrining</h4>
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="bg-slate-50 rounded-2xl p-3">
                        <p class="text-xl font-black text-slate-800">{{ $totalScreenings }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Total</p>
                    </div>
                    <div class="bg-emerald-50 rounded-2xl p-3">
                        <p class="text-xl font-black text-emerald-700">{{ $completedScreenings }}</p>
                        <p class="text-[9px] font-bold text-emerald-400 uppercase mt-1">Selesai</p>
                    </div>
                    <div class="bg-rose-50 rounded-2xl p-3">
                        <p class="text-xl font-black text-rose-600">{{ $emergencyCount }}</p>
                        <p class="text-[9px] font-bold text-rose-400 uppercase mt-1">Darurat</p>
                    </div>
                </div>
            </div>

            {{-- Last Session Summary --}}
            @if($lastSession)
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Skrining Terakhir</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500 font-medium">Tanggal</span>
                        <span class="text-xs font-bold text-slate-700">{{ $lastSession->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500 font-medium">Skor Total</span>
                        <span class="text-xs font-black text-slate-800">{{ $lastSession->score_total ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500 font-medium">Tingkat Depresi</span>
                        @php
                            $level = $lastSession->depression_level?->value ?? 'kritis';
                            $levelClass = match($level) {
                                'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                                'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'ringan' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                default => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-black uppercase border {{ $levelClass }}">
                            {{ ucfirst($level) }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Right: Riwayat + Chart --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Score Trend Chart --}}
            @if(count($chartLabels) > 0)
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                <h4 class="text-sm font-bold text-slate-800 mb-1">Tren Skor Skrining</h4>
                <p class="text-xs text-slate-400 mb-5">5 sesi skrining terakhir</p>
                <div class="relative h-48">
                    <canvas id="scoreChart"></canvas>
                </div>
            </div>
            @endif

            {{-- Riwayat Skrining --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Riwayat Skrining</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Semua sesi penilaian yang telah dilakukan</p>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl">
                        {{ $totalScreenings }} Sesi
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                <th class="py-3 px-6">Tanggal</th>
                                <th class="py-3 px-6 text-center">Skor Total</th>
                                <th class="py-3 px-6 text-center">Kognitif</th>
                                <th class="py-3 px-6 text-center">Somatik</th>
                                <th class="py-3 px-6 text-center">Tingkat Depresi</th>
                                <th class="py-3 px-6 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($sessions as $session)
                                <tr class="hover:bg-slate-50/40 transition-colors">
                                    <td class="py-4 px-6">
                                        <p class="font-semibold text-slate-700 text-xs">{{ $session->created_at->format('d M Y') }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $session->created_at->format('H:i') }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="font-black text-slate-800">{{ $session->score_total ?? '—' }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-center text-xs text-slate-600">{{ $session->score_cognitive_affective ?? '—' }}</td>
                                    <td class="py-4 px-6 text-center text-xs text-slate-600">{{ $session->score_somatic ?? '—' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if($session->depression_level)
                                            @php
                                                $lv = $session->depression_level->value;
                                                $lc = match($lv) {
                                                    'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                    'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                    'ringan' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                                    default => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                };
                                            @endphp
                                            <span class="inline-flex px-2 py-0.5 rounded-lg text-[9px] font-black uppercase border {{ $lc }}">{{ ucfirst($lv) }}</span>
                                        @else
                                            <span class="text-slate-400 text-xs">—</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            $st = $session->status->value;
                                            $sc = match($st) {
                                                'emergency_stopped' => 'bg-rose-100 text-rose-700 border-rose-200',
                                                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                default => 'bg-slate-100 text-slate-600 border-slate-200',
                                            };
                                            $sl = match($st) {
                                                'emergency_stopped' => 'Darurat',
                                                'completed' => 'Selesai',
                                                default => 'Berlangsung',
                                            };
                                        @endphp
                                        <span class="inline-flex px-2 py-0.5 rounded-lg text-[9px] font-black uppercase border {{ $sc }}">{{ $sl }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-slate-400 text-sm italic">
                                        Pengguna ini belum pernah melakukan skrining.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Script --}}
    @if(count($chartLabels) > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('scoreChart');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Skor Total',
                        data: @json($chartScores),
                        borderColor: '#0d7a70',
                        backgroundColor: 'rgba(13,122,112,0.06)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#0d7a70',
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, max: 63, grid: { color: '#f8fafc' }, ticks: { font: { size: 10 } } },
                        x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                    }
                }
            });
        });
    </script>
    @endif
</x-admin-layout>
