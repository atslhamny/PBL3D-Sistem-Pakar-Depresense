@php
    $levelStyles = match($session->depression_level->value) {
        'minimal' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'ringan'  => 'bg-amber-50 text-amber-700 border-amber-100',
        'sedang'  => 'bg-orange-50 text-orange-700 border-orange-100',
        'berat'   => 'bg-rose-50 text-rose-700 border-rose-100',
        default   => 'bg-slate-50 text-slate-700 border-slate-100',
    };

    $appreciationData = match($session->depression_level->value) {
        'minimal' => [
            'icon'    => '🌟',
            'title'   => 'Luar Biasa! Kamu Melakukan Hal yang Tepat',
            'message' => 'Terima kasih telah meluangkan waktu untuk mengenal dirimu lebih dalam. Hasil menunjukkan kondisi mentalmu sangat baik — teruslah jaga pola hidup sehat dan semangat positif yang sudah kamu miliki!',
            'gradient'=> 'from-emerald-500 to-teal-500',
            'bg'      => 'bg-emerald-50',
            'border'  => 'border-emerald-200',
            'text'    => 'text-emerald-800',
            'sub'     => 'text-emerald-600',
        ],
        'ringan'  => [
            'icon'    => '💛',
            'title'   => 'Berani & Jujur — Itu Sudah Langkah Besar!',
            'message' => 'Mengakui perasaanmu dengan jujur adalah tanda keberanian yang luar biasa. Kamu tidak sendirian — dengan dukungan yang tepat dan langkah kecil setiap hari, kamu pasti bisa melewati ini. Kami bangga kamu sudah mau mengenal dirimu lebih baik!',
            'gradient'=> 'from-amber-400 to-yellow-400',
            'bg'      => 'bg-amber-50',
            'border'  => 'border-amber-200',
            'text'    => 'text-amber-800',
            'sub'     => 'text-amber-600',
        ],
        'sedang'  => [
            'icon'    => '🤝',
            'title'   => 'Terima Kasih Sudah Mempercayai Dirimu Sendiri',
            'message' => 'Sungguh butuh keberanian untuk mengisi skrining ini dengan jujur. Hasil ini bukan akhir — ini adalah awal dari perjalananmu menuju kesehatan yang lebih baik. Yuk, ambil satu langkah kecil hari ini, dan ingat: meminta bantuan adalah tanda kekuatan, bukan kelemahan.',
            'gradient'=> 'from-orange-400 to-amber-500',
            'bg'      => 'bg-orange-50',
            'border'  => 'border-orange-200',
            'text'    => 'text-orange-800',
            'sub'     => 'text-orange-600',
        ],
        'berat'   => [
            'icon'    => '💙',
            'title'   => 'Kamu Sudah Melakukan Sesuatu yang Luar Biasa Hari Ini',
            'message' => 'Mengisi skrining ini adalah langkah pertama yang penuh keberanian. Kami sangat menghargai kepercayaan dan kejujuranmu. Tolong ingat — kamu tidak harus menghadapi ini sendirian. Ada orang-orang yang peduli dan siap membantumu. Ini bukan akhir ceritamu; ini bab baru yang bisa berubah menjadi lebih baik.',
            'gradient'=> 'from-blue-500 to-indigo-500',
            'bg'      => 'bg-blue-50',
            'border'  => 'border-blue-200',
            'text'    => 'text-blue-800',
            'sub'     => 'text-blue-600',
        ],
        default   => [
            'icon'    => '✨',
            'title'   => 'Terima Kasih Telah Menyelesaikan Skrining',
            'message' => 'Langkah ini adalah tanda kepedulianmu terhadap diri sendiri. Teruslah menjaga kesehatan mentalmu dengan penuh kasih sayang.',
            'gradient'=> 'from-slate-400 to-slate-500',
            'bg'      => 'bg-slate-50',
            'border'  => 'border-slate-200',
            'text'    => 'text-slate-800',
            'sub'     => 'text-slate-600',
        ],
    };
@endphp

@if(auth()->check())
<x-app-layout>
    <x-slot name="title">Hasil Assessment | DepreSense</x-slot>

    <div class="w-full bg-white">
        </div>

    {{-- ⚠️ EMERGENCY BANNER — shown only when suicide ideation was detected --}}
    @if($emergencyTriggered)
    <div class="mb-8 rounded-[2rem] overflow-hidden shadow-lg border border-rose-200"
         x-data="{ open: true }" x-show="open"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <div class="bg-gradient-to-r from-rose-600 to-rose-500 p-6 flex items-start gap-5">
            <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-white font-extrabold text-lg mb-1">Anda Tidak Sendirian</h3>
                <p class="text-rose-100 text-sm leading-relaxed mb-4">
                    Kami memperhatikan salah satu jawaban Anda menyiratkan pikiran yang mengkhawatirkan. Ini adalah hal yang serius dan kami sangat menyarankan Anda untuk segera menghubungi bantuan profesional.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="tel:119" class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-rose-600 font-bold rounded-xl hover:bg-rose-50 transition-colors text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Hubungi 119 Ext 8 (Sejiwa)
                    </a>
                    <button @click="open = false" class="inline-flex items-center justify-center px-5 py-2.5 bg-white/10 text-white font-semibold rounded-xl hover:bg-white/20 transition-colors text-sm border border-white/20">
                        Saya sudah memahami
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="text-center mb-8 mt-6">
        <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Hasil Assessment</h2>
        <p class="text-slate-500 text-sm">Berdasarkan jawaban Anda pada kuesioner BDI-II</p>
    </div>

    {{-- ✨ APPRECIATION BANNER --}}
    <div class="mb-10 rounded-[2rem] overflow-hidden shadow-md border {{ $appreciationData['border'] }}"
         x-data="{ visible: false }"
         x-init="setTimeout(() => visible = true, 100)"
         x-show="visible"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <div class="bg-gradient-to-r {{ $appreciationData['gradient'] }} px-6 py-1"></div>
        <div class="{{ $appreciationData['bg'] }} px-7 py-6 flex items-start gap-5">
            <div class="flex-shrink-0 text-4xl leading-none mt-1">{{ $appreciationData['icon'] }}</div>
            <div class="flex-1">
                <h3 class="{{ $appreciationData['text'] }} font-extrabold text-base mb-1.5">{{ $appreciationData['title'] }}</h3>
                <p class="{{ $appreciationData['sub'] }} text-sm leading-relaxed">{{ $appreciationData['message'] }}</p>
            </div>
        </div>
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
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1 relative z-10">Skor Analisis</span>
            <span class="text-2xl font-bold text-[#0d7a70] relative z-10">{{ $session->fuzzy_centroid_value }}</span>
        </div>
    </div>

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

    <div class="text-center mt-4">
        <a href="{{ route('user.dashboard') }}" class="inline-flex justify-center items-center px-6 py-2 text-sm font-semibold text-slate-400 hover:text-[#0d7a70] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</x-app-layout>
@else
<x-guest-layout maxWidth="sm:max-w-3xl">
    {{-- ⚠️ EMERGENCY BANNER — shown only when suicide ideation was detected --}}
    @if($emergencyTriggered)
    <div class="mb-8 rounded-[2rem] overflow-hidden shadow-lg border border-rose-200"
         x-data="{ open: true }" x-show="open"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <div class="bg-gradient-to-r from-rose-600 to-rose-500 p-6 flex items-start gap-5">
            <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-white font-extrabold text-lg mb-1">Anda Tidak Sendirian</h3>
                <p class="text-rose-100 text-sm leading-relaxed mb-4">
                    Kami memperhatikan salah satu jawaban Anda menyiratkan pikiran yang mengkhawatirkan. Ini adalah hal yang serius dan kami sangat menyarankan Anda untuk segera menghubungi bantuan profesional.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="tel:119" class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-rose-600 font-bold rounded-xl hover:bg-rose-50 transition-colors text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Hubungi 119 Ext 8 (Sejiwa)
                    </a>
                    <button @click="open = false" class="inline-flex items-center justify-center px-5 py-2.5 bg-white/10 text-white font-semibold rounded-xl hover:bg-white/20 transition-colors text-sm border border-white/20">
                        Saya sudah memahami
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="text-center mb-8 mt-6">
        <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Hasil Assessment</h2>
        <p class="text-slate-500 text-sm">Berdasarkan jawaban Anda pada kuesioner BDI-II</p>
    </div>

    {{-- ✨ APPRECIATION BANNER --}}
    <div class="mb-10 rounded-[2rem] overflow-hidden shadow-md border {{ $appreciationData['border'] }}"
         x-data="{ visible: false }"
         x-init="setTimeout(() => visible = true, 100)"
         x-show="visible"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <div class="bg-gradient-to-r {{ $appreciationData['gradient'] }} px-6 py-1"></div>
        <div class="{{ $appreciationData['bg'] }} px-7 py-6 flex items-start gap-5">
            <div class="flex-shrink-0 text-4xl leading-none mt-1">{{ $appreciationData['icon'] }}</div>
            <div class="flex-1">
                <h3 class="{{ $appreciationData['text'] }} font-extrabold text-base mb-1.5">{{ $appreciationData['title'] }}</h3>
                <p class="{{ $appreciationData['sub'] }} text-sm leading-relaxed">{{ $appreciationData['message'] }}</p>
            </div>
        </div>
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
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1 relative z-10">Skor Analisis</span>
            <span class="text-2xl font-bold text-[#0d7a70] relative z-10">{{ $session->fuzzy_centroid_value }}</span>
        </div>
    </div>

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

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-6 py-2 text-sm font-semibold text-slate-400 hover:text-[#0d7a70] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</x-guest-layout>
@endif