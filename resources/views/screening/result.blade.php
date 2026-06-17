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
            'title'       => 'Terima kasih telah menyelesaikan skrining.',
            'message'     => 'Kondisi mentalmu terlihat baik. Teruslah jaga pola hidup sehat dan tetap terhubung dengan orang-orang yang kamu sayangi.',
            'borderColor' => 'border-emerald-400',
            'textColor'   => 'text-emerald-700',
            'barColor'    => 'bg-emerald-400',
        ],
        'ringan'  => [
            'title'       => 'Langkah berani yang sudah kamu ambil hari ini.',
            'message'     => 'Mengisi skrining ini dengan jujur adalah awal yang baik. Kamu tidak sendirian — dukungan selalu tersedia untukmu.',
            'borderColor' => 'border-amber-400',
            'textColor'   => 'text-amber-700',
            'barColor'    => 'bg-amber-400',
        ],
        'sedang'  => [
            'title'       => 'Terima kasih atas kejujuranmu.',
            'message'     => 'Ini bukan akhir, melainkan titik awal perjalanan menuju kondisi yang lebih baik. Meminta bantuan adalah tanda kekuatan.',
            'borderColor' => 'border-orange-400',
            'textColor'   => 'text-orange-700',
            'barColor'    => 'bg-orange-400',
        ],
        'berat'   => [
            'title'       => 'Kamu sudah melakukan sesuatu yang penting hari ini.',
            'message'     => 'Kami menghargai keberanianmu. Tolong ingat — kamu tidak harus menghadapi ini sendirian.',
            'borderColor' => 'border-blue-400',
            'textColor'   => 'text-blue-700',
            'barColor'    => 'bg-blue-400',
        ],
        default   => [
            'title'       => 'Terima kasih telah menyelesaikan skrining.',
            'message'     => 'Langkah ini adalah tanda kepedulianmu terhadap diri sendiri.',
            'borderColor' => 'border-slate-300',
            'textColor'   => 'text-slate-600',
            'barColor'    => 'bg-slate-400',
        ],
    };
@endphp

{{--
    TOAST MODAL APRESIASI — fixed bottom-right, auto-dismiss 5 detik.
    Menggunakan position:fixed sehingga TIDAK pernah tabrakan dengan
    emergency banner yang berada di flow normal halaman.
--}}
<div
    x-data="{
        show: false,
        progress: 100,
        interval: null,
        start() {
            this.show = true;
            const step = 50;
            const duration = 5000;
            this.interval = setInterval(() => {
                this.progress -= (step / duration) * 100;
                if (this.progress <= 0) this.dismiss();
            }, step);
        },
        dismiss() {
            clearInterval(this.interval);
            this.show = false;
        }
    }"
    x-init="setTimeout(() => start(), 700)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-3"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-3"
    class="fixed bottom-4 right-4 z-50 w-[calc(100vw-2rem)] max-w-sm bg-white rounded-2xl shadow-lg border border-slate-100 border-l-4 {{ $appreciationData['borderColor'] }} overflow-hidden"
    style="display:none;"
>
    <div class="px-4 pt-4 pb-3 flex items-start gap-3">
        <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold {{ $appreciationData['textColor'] }} leading-snug mb-0.5">{{ $appreciationData['title'] }}</p>
            <p class="text-xs text-slate-500 leading-relaxed">{{ $appreciationData['message'] }}</p>
        </div>
        <button @click="dismiss()" class="flex-shrink-0 text-slate-300 hover:text-slate-500 transition-colors mt-0.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    {{-- Progress bar countdown --}}
    <div class="h-0.5 bg-slate-100">
        <div class="{{ $appreciationData['barColor'] }} h-full transition-none" :style="`width: ${progress}%`"></div>
    </div>
</div>

@if(auth()->check())
<x-app-layout>
    <x-slot name="title">Hasil Assessment | DepreSense</x-slot>

    <div class="w-full bg-white"></div>

    {{-- ⚠️ EMERGENCY BANNER — tetap inline di halaman, tidak auto-dismiss --}}
    @if($emergencyTriggered)
    <div class="mb-8 rounded-2xl overflow-hidden border border-rose-200 shadow-sm"
         x-data="{ open: true }" x-show="open"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="bg-rose-600 px-5 py-4 flex items-start gap-4">
            <div class="flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-white font-semibold text-sm mb-1">Anda Tidak Sendirian</p>
                <p class="text-rose-100 text-xs leading-relaxed mb-3">Kami memperhatikan salah satu jawaban Anda menyiratkan pikiran yang mengkhawatirkan. Bantuan profesional tersedia untuk Anda.</p>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="tel:119" class="inline-flex items-center justify-center px-4 py-2 bg-white text-rose-600 font-semibold rounded-xl text-xs hover:bg-rose-50 transition-colors">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Hubungi 119 Ext 8
                    </a>
                    <button @click="open = false" class="inline-flex items-center justify-center px-4 py-2 bg-white/10 text-white font-medium rounded-xl text-xs hover:bg-white/20 transition-colors border border-white/20">
                        Saya memahami
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

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 hover:shadow-md transition-shadow duration-300">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Skor Kognitif</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_cognitive_affective }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 hover:shadow-md transition-shadow duration-300">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Skor Somatik</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_somatic }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 hover:shadow-md transition-shadow duration-300">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Total BDI-II</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_total }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
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
    {{-- ⚠️ EMERGENCY BANNER — tetap inline di halaman, tidak auto-dismiss --}}
    @if($emergencyTriggered)
    <div class="mb-8 rounded-2xl overflow-hidden border border-rose-200 shadow-sm"
         x-data="{ open: true }" x-show="open"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="bg-rose-600 px-5 py-4 flex items-start gap-4">
            <div class="flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-white font-semibold text-sm mb-1">Anda Tidak Sendirian</p>
                <p class="text-rose-100 text-xs leading-relaxed mb-3">Kami memperhatikan salah satu jawaban Anda menyiratkan pikiran yang mengkhawatirkan. Bantuan profesional tersedia untuk Anda.</p>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="tel:119" class="inline-flex items-center justify-center px-4 py-2 bg-white text-rose-600 font-semibold rounded-xl text-xs hover:bg-rose-50 transition-colors">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Hubungi 119 Ext 8
                    </a>
                    <button @click="open = false" class="inline-flex items-center justify-center px-4 py-2 bg-white/10 text-white font-medium rounded-xl text-xs hover:bg-white/20 transition-colors border border-white/20">
                        Saya memahami
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

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 hover:shadow-md transition-shadow duration-300">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Skor Kognitif</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_cognitive_affective }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 hover:shadow-md transition-shadow duration-300">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Skor Somatik</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_somatic }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 hover:shadow-md transition-shadow duration-300">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Total BDI-II</span>
            <span class="text-2xl font-bold text-[#0d7a70]">{{ $session->score_total }}</span>
        </div>
        <div class="bg-slate-50 rounded-3xl p-4 text-center border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
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