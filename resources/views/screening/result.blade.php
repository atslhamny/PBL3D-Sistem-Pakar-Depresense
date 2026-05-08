<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-2">Hasil Assessment</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Berdasarkan jawaban Anda pada kuesioner BDI-II</p>
    </div>

    <!-- Score Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl p-4 text-center border border-indigo-100 dark:border-indigo-800/50">
            <span class="block text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-1">Skor Kognitif</span>
            <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $session->score_cognitive_affective }}</span>
        </div>
        <div class="bg-cyan-50 dark:bg-cyan-900/20 rounded-2xl p-4 text-center border border-cyan-100 dark:border-cyan-800/50">
            <span class="block text-xs font-semibold text-cyan-600 dark:text-cyan-400 uppercase tracking-wider mb-1">Skor Somatik</span>
            <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $session->score_somatic }}</span>
        </div>
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-4 text-center border border-blue-100 dark:border-blue-800/50">
            <span class="block text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">Total BDI-II</span>
            <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $session->score_total }}</span>
        </div>
        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-2xl p-4 text-center border border-purple-100 dark:border-purple-800/50 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-indigo-500 opacity-10 group-hover:opacity-20 transition-opacity"></div>
            <span class="block text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-1 relative z-10">Fuzzy (0-100)</span>
            <span class="text-2xl font-bold text-slate-800 dark:text-white relative z-10">{{ $session->fuzzy_centroid_value }}</span>
        </div>
    </div>

    <!-- Result Box -->
    @php
        $levelColor = match($session->depression_level->value) {
            'minimal' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800/50',
            'ringan' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300 dark:border-yellow-800/50',
            'sedang' => 'bg-orange-100 text-orange-800 border-orange-200 dark:bg-orange-900/30 dark:text-orange-300 dark:border-orange-800/50',
            'berat' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800/50',
        };
    @endphp

    <div class="mb-8">
        <div class="text-center p-6 rounded-2xl border-2 {{ $levelColor }} shadow-sm">
            <span class="block text-sm font-semibold uppercase tracking-wider mb-1 opacity-80">Tingkat Indikasi Depresi</span>
            <h3 class="text-3xl sm:text-4xl font-black capitalize tracking-tight">{{ $session->depression_level->value }}</h3>
        </div>
    </div>

    <!-- Recommendations -->
    <div class="mb-8 bg-white dark:bg-slate-800/50 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80">
            <h4 class="font-bold text-slate-800 dark:text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Rekomendasi Awal
            </h4>
        </div>
        <div class="p-6">
            <ul class="space-y-3">
                @foreach($recommendations as $rec)
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-3 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-slate-600 dark:text-slate-300">{{ $rec }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @guest
        <div class="p-5 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/50 rounded-2xl text-center mb-6">
            <p class="text-sm text-indigo-800 dark:text-indigo-300 mb-4 font-medium">Buat akun untuk menyimpan hasil ini dan memantau perkembangan Anda di kemudian hari.</p>
            <a href="{{ route('register') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-xl font-medium shadow-sm hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">Daftar Sekarang</a>
        </div>
    @endguest

    <div class="text-center">
        <a href="{{ auth()->check() ? route('user.dashboard') : route('home') }}" class="inline-flex justify-center items-center px-6 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm text-base font-medium text-slate-700 bg-white hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 focus:outline-none transition-colors">
            Kembali ke Beranda
        </a>
    </div>
</x-guest-layout>
