<x-app-layout>
    {{-- Bagian Atas: Salam Pembuka & Tombol Aksi --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            {{-- Dikembalikan menggunakan full_name karena kolomnya terbukti ada di model User --}}
            <h2 class="text-2xl font-bold text-slate-800">
                Halo, {{ Auth::check() ? Auth::user()->full_name : 'Mahasiswa' }}
            </h2>
            <p class="text-slate-500 text-sm mt-1">Berikut adalah ringkasan kesehatan mental Anda saat ini.</p>
        </div>
        
        <a href="{{ route('screening.consent') }}" class="flex items-center px-5 py-2.5 bg-[#0d7a70] text-white text-sm font-bold rounded-xl hover:bg-[#0a635b] transition-all shadow-sm shadow-teal-100">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            {{ $latestSession ? 'Mulai Penilaian Baru' : 'Mulai Assessment' }}
        </a>
    </div>

    {{-- Logika Kondisi Berdasarkan Riwayat Assessment --}}
    @if($latestSession)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
            {{-- Card STATUS SAAT INI --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[200px]">
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status Saat Ini</span>
                        <span class="text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </span>
                    </div>
                    
                    {{-- Badge Kategori Hasil Indikasi adaptif --}}
                    @php
                        // Memberikan fallback string kosong jika value bernilai null agar tidak crash
                        $level = strtolower($latestSession->depression_level->value ?? '');
                        $badgeClass = 'bg-slate-50 text-slate-500 border-slate-100';
                        $description = 'Tetap pantau kondisi kesehatan mental Anda secara berkala.';
                        
                        if ($level === 'minimal') {
                            $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                            $description = 'Tingkat stres Anda terpantau aman dan berada dalam batas wajar.';
                        } elseif (in_array($level, ['ringan', 'sedang'])) {
                            $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100';
                            $description = 'Tingkat stres terpantau sedang, namun perlu sedikit perhatian pada rutinitas istirahat.';
                        } elseif ($level === 'berat') {
                            $badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';
                            $description = 'Indikasi tingkat depresi Anda cukup tinggi. Mohon pertimbangkan berkonsultasi dengan profesional.';
                        }
                    @endphp

                    <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-bold capitalize {{ $badgeClass }} mb-3">
                        <span class="h-1.5 w-1.5 rounded-full bg-currentColor mr-2"></span>
                        {{ $latestSession->depression_level->value ?? 'Tidak Diketahui' }}
                    </span>
                    
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        {{ $description }}
                    </p>
                </div>
                
                <div class="text-[10px] text-slate-400 font-medium pt-3 border-t border-slate-50">
                    {{-- Proteksi Carbon format jika completed_at berupa string --}}
                    Terakhir diperbarui: {{ flex_date_format($latestSession->completed_at) }}
                </div>
            </div>

            {{-- Card SKOR TERAKHIR --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Skor Terakhir</span>
                    <span class="text-4xl font-extrabold text-slate-800">{{ $latestSession->score_total }}</span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-xl flex items-center text-[11px] text-slate-500 font-medium">
                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Skor berdasarkan kuesioner BDI-II
                </div>
            </div>

            {{-- Card TANGGAL PENILAIAN --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Tanggal Assessment</span>
                    <span class="text-lg font-bold text-slate-700 block mt-2">{{ flex_date_format($latestSession->completed_at, 'd M Y') }}</span>
                    <span class="text-xs text-slate-400">Pukul {{ flex_date_format($latestSession->completed_at, 'H:i') }} WIB</span>
                </div>
                <div class="text-[11px] text-slate-400">
                    Sesi tersimpan secara aman
                </div>
            </div>

            {{-- Card REKOMENDASI HARI INI --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Rekomendasi Kegiatan</span>
                    <p class="text-xs font-bold text-[#0d7a70] mb-1">Meditasi Pernafasan</p>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Latihan 5 menit untuk membantu menurunkan frekuensi detak jantung dan rileksasi saraf.</p>
                </div>
                <a href="#" class="text-xs font-bold text-[#0d7a70] hover:underline flex items-center">
                    Buka Panduan
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

        </div>

        {{-- Grafik Riwayat Penilaian Pendukung --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-1">Riwayat Penilaian</h3>
            <p class="text-xs text-slate-400 mb-6">Grafik fluktuasi tingkat indikasi stres Anda</p>
            
            <div class="h-48 w-full bg-slate-50/50 rounded-xl flex items-center justify-center border border-dashed border-slate-200">
                <span class="text-xs text-slate-400 italic">Visualisasi data grafik riwayat (ChartJS) akan dimuat di sini</span>
            </div>
        </div>

    @else
        {{-- State Kosong: Jika User Belum Pernah Melakukan Screening --}}
        <div class="bg-white border border-slate-100 rounded-[2rem] p-12 flex flex-col items-center justify-center min-h-[400px] shadow-sm">
            <div class="mb-6 p-6 bg-[#f0f9fa] rounded-full text-[#0d7a70]">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>

            <div class="max-w-md text-center">
                <h3 class="text-xl font-extrabold text-slate-800 mb-2">Belum Ada Riwayat Assessment</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-8">
                    Mulai assessment pertama Anda menggunakan standar kuesioner BDI-II untuk mendeteksi serta mengetahui kondisi kesehatan mental Anda.
                </p>
                
                <a href="{{ route('screening.consent') }}" class="inline-flex justify-center items-center px-6 py-3 bg-[#0d7a70] text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-[#0a635b] transition-all shadow-md shadow-teal-700/10">
                    Mulai Assessment Pertama
                </a>
            </div>
        </div>
    @endif
</x-app-layout>

{{-- Helper Fungsi Blade lokal untuk mengamankan parsing tanggal Carbon --}}
@php
    if (!function_exists('flex_date_format')) {
        function flex_date_format($date, $format = 'd M, H:i') {
            if (!$date) return '-';
            if ($date instanceof \Carbon\Carbon) {
                return $date->format($format);
            }
            return \Carbon\Carbon::parse($date)->format($format);
        }
    }
@endphp