<x-guest-layout maxWidth="sm:max-w-3xl"> <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Hasil Assessment</h2>
        <p class="text-slate-500 text-sm">Berdasarkan jawaban Anda pada kuesioner BDI-II</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 transition-hover duration-300 hover:shadow-md">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Skor Kognitif</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_cognitive_affective }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 transition-hover duration-300 hover:shadow-md">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Skor Somatik</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_somatic }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 transition-hover duration-300 hover:shadow-md">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Total BDI-II</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_total }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 relative overflow-hidden group transition-hover duration-300 hover:shadow-md">
            <div class="absolute inset-0 bg-[#0d7a70] opacity-5 group-hover:opacity-10 transition-opacity"></div>
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1 relative z-10">Fuzzy Value</span>
            <span class="text-2xl font-bold text-[#0d7a70] relative z-10">{{ $session->fuzzy_centroid_value }}</span>
        </div>
    </div>

    @php
        $levelStyles = match($session->depression_level->value) {
            'minimal' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            'ringan'  => 'bg-amber-50 text-amber-700 border-amber-100',
            'sedang'  => 'bg-orange-50 text-orange-700 border-orange-100',
            'berat'   => 'bg-rose-50 text-rose-700 border-rose-100',
        };
    @endphp

    <div class="mb-10">
        <div class="text-center p-8 rounded-[2rem] border-2 {{ $levelStyles }} shadow-sm">
            <span class="block text-xs font-bold uppercase tracking-[0.2em] mb-2 opacity-70">Tingkat Indikasi Depresi</span>
            <h3 class="text-4xl font-black capitalize tracking-tight">{{ $session->depression_level->value }}</h3>
        </div>
    </div>

    <div class="mb-10 bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
        <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/50">
            <h4 class="font-bold text-slate-800 flex items-center">
                <svg class="w-5 h-5 mr-3 text-[#0d7a70]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Rekomendasi Langkah Awal
            </h4>
        </div>
        <div class="p-8">
            <ul class="space-y-4">
                @foreach($recommendations as $rec)
                    <li class="flex items-start">
                        <div class="mt-1 bg-emerald-100 rounded-full p-1 mr-4">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-slate-600 leading-relaxed">{{ $rec }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @guest
        <div class="p-8 bg-[#f0f9fa] border border-cyan-100 rounded-[2rem] text-center mb-8">
            <p class="text-sm text-slate-600 mb-6 font-medium">Simpan hasil assessment ini untuk memantau perkembangan kesehatan mental Anda secara berkala.</p>
            <a href="{{ route('register') }}" class="inline-block bg-[#0d7a70] text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-[#0d7a70]/20 hover:bg-[#0a635b] hover:-translate-y-0.5 transition-all duration-300">
                Daftar Akun Sekarang
            </a>
        </div>
    @endguest

    <div class="text-center">
        <a href="{{ auth()->check() ? route('user.dashboard') : route('home') }}" class="inline-flex justify-center items-center px-6 py-2 text-sm font-semibold text-slate-400 hover:text-[#0d7a70] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</x-guest-layout>