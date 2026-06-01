<x-app-layout>
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center text-sm font-semibold text-slate-400 mb-4">
            <a href="{{ route('user.history') }}" class="hover:text-[#0d7a70] transition-colors">Riwayat</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-slate-600">Analisis Insight</span>
        </div>
        
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Analisis Insight</h2>
        <p class="text-slate-500 text-sm leading-relaxed max-w-2xl">
            Breakdown kondisi kesehatan mental Anda berdasarkan penilaian pada {{ $session->completed_at ? $session->completed_at->format('d F Y') : '-' }}.
        </p>
    </div>

    @php
        // Kalkulasi persentase
        $pctKognitif = min(100, round(($session->score_cognitive_affective / 39) * 100));
        $pctSomatik = min(100, round(($session->score_somatic / 24) * 100));
        $pctFuzzy = min(100, round($session->fuzzy_centroid_value));
        
        // Logika Status Keseluruhan
        $level = strtolower($session->depression_level->value ?? '');
        $statusTitle = 'Kondisi Stabil';
        $statusDesc = 'Secara keseluruhan, metrik Anda menunjukkan stabilitas yang baik. Tetap pertahankan rutinitas sehat Anda.';
        $statusBg = 'bg-[#377b75] text-white';
        $statusIcon = '<svg class="w-5 h-5 text-teal-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        
        if (in_array($level, ['ringan', 'sedang'])) {
            $statusTitle = 'Perlu Perhatian';
            $statusDesc = 'Terdapat sedikit fluktuasi pada metrik emosional dan fisik Anda. Disarankan untuk mengambil jeda sejenak.';
            $statusBg = 'bg-amber-600 text-white';
            $statusIcon = '<svg class="w-5 h-5 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
        } elseif ($level === 'berat') {
            $statusTitle = 'Indikasi Tinggi';
            $statusDesc = 'Metrik Anda menunjukkan beban yang cukup berat pada sistem kognitif dan somatik. Mohon pertimbangkan untuk mencari bantuan profesional.';
            $statusBg = 'bg-rose-600 text-white';
            $statusIcon = '<svg class="w-5 h-5 text-rose-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
        }
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        
        {{-- Card Distribusi Kategori --}}
        <div class="lg:col-span-2 bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-bold text-slate-800">Distribusi Kategori</h3>
                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase tracking-widest">
                    Assessment BDI-II
                </span>
            </div>

            <div class="space-y-8">
                {{-- Emosi & Kognitif --}}
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-slate-700">Kognitif & Afektif</span>
                        <span class="text-sm font-extrabold text-[#377b75]">{{ $pctKognitif }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-[#377b75] h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $pctKognitif }}%"></div>
                    </div>
                </div>

                {{-- Fisik / Somatik --}}
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-slate-700">Somatik (Fisik)</span>
                        <span class="text-sm font-extrabold text-[#377b75]">{{ $pctSomatik }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-teal-400 h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $pctSomatik }}%"></div>
                    </div>
                </div>

                {{-- Nilai Fuzzy --}}
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-slate-700">Fuzzy Logic Value</span>
                        <span class="text-sm font-extrabold text-[#377b75]">{{ $pctFuzzy }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-teal-200 h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $pctFuzzy }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Kondisi Stabil --}}
        <div class="{{ $statusBg }} rounded-[2rem] p-8 shadow-lg flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            </div>
            
            <div class="relative z-10">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-6 backdrop-blur-sm">
                    {!! $statusIcon !!}
                </div>
                
                <h3 class="text-2xl font-bold mb-4">{{ $statusTitle }}</h3>
                <p class="text-sm leading-relaxed opacity-90 mb-8">
                    {{ $statusDesc }}
                </p>
            </div>
            
            <div class="relative z-10 mt-auto">
                <a href="{{ route('screening.consent') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-white/20 hover:bg-white/30 transition-colors rounded-xl text-sm font-bold backdrop-blur-md border border-white/10">
                    Re-Assessment
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- 3 Card Detail Insight --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Emosi / Kognitif --}}
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="font-bold text-slate-800">Kognitif & Afektif</h4>
            </div>
            <p class="text-sm text-slate-500 leading-relaxed">
                Tingkat kognitif-afektif tercatat <strong>{{ $session->score_cognitive_affective }} dari 39</strong>. 
                @if($pctKognitif > 50)
                    Anda mungkin mengalami fluktuasi suasana hati yang signifikan. Disarankan untuk meluangkan waktu relaksasi sejenak.
                @else
                    Fokus dan emosi Anda berada pada tingkat stabil. Tidak ada indikasi gangguan pikiran (brain fog) yang berarti.
                @endif
            </p>
        </div>

        {{-- Somatik / Fisik --}}
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h4 class="font-bold text-slate-800">Somatik (Fisik)</h4>
            </div>
            <p class="text-sm text-slate-500 leading-relaxed">
                Gejala fisik tercatat <strong>{{ $session->score_somatic }} dari 24</strong>.
                @if($pctSomatik > 50)
                    Ada kemungkinan kualitas tidur dan energi Anda menurun. Perhatikan asupan cairan dan waktu istirahat.
                @else
                    Kualitas tidur dan energi fisik tampak baik sepanjang hari, mendukung ketahanan mental Anda secara penuh.
                @endif
            </p>
        </div>

        {{-- Fuzzy Logic Status --}}
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                </div>
                <h4 class="font-bold text-slate-800">Sistem Pakar</h4>
            </div>
            <p class="text-sm text-slate-500 leading-relaxed">
                Inferensi Fuzzy Mamdani menyimpulkan hasil pada nilai <strong>{{ $session->fuzzy_centroid_value }}</strong>. Kategori ini termasuk dalam himpunan keanggotaan <strong>{{ strtoupper($session->depression_level->value) }}</strong>.
            </p>
        </div>
        
    </div>
</x-app-layout>
