<x-guest-layout>
    <div class="text-center">
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Sistem Pakar Deteksi Dini Depresi</h2>
        
        <p class="text-slate-500 mb-8 text-sm leading-relaxed px-2">
            Menganalisis dan mendeteksi potensi tingkat depresi secara akurat menggunakan metode <strong>Fuzzy Mamdani</strong> dan kuesioner klinis <strong>BDI-II</strong>.
        </p>

        <div class="space-y-4">
            <a href="{{ route('screening.consent') }}" 
               class="block w-full px-6 py-4 text-center text-white bg-[#00aba9] hover:bg-[#0d7a70] rounded-2xl font-semibold transition-all shadow-md shadow-teal-100 active:scale-[0.98]">
                Mulai Assessment
            </a>
            
            <div class="relative flex items-center py-6"> <div class="flex-grow border-t-2 border-slate-200"></div>
                <span class="flex-shrink-0 px-4 text-xs text-slate-500 uppercase font-bold tracking-widest">
                    Atau
                </span>
                <div class="flex-grow border-t-2 border-slate-200"></div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('login') }}" 
                class="px-6 py-3.5 text-center text-[#0d7a70] bg-[#e6f4f3] hover:bg-[#d1edeb] rounded-2xl font-bold transition-all border border-[#b2e0dd] shadow-sm active:scale-95">
                    Masuk
                </a>
                <a href="{{ route('register') }}" 
                class="px-6 py-3.5 text-center text-slate-600 bg-white hover:bg-slate-50 rounded-2xl font-semibold transition-all border border-slate-200 shadow-sm active:scale-95">
                    Daftar
                </a>
            </div>
        </div>

        <div class="mt-10 text-[11px] text-slate-400 leading-tight">
            <p>*Hasil akan disimpan secara aman dan Anda dapat melihat riwayat perkembangan jika melakukan pendaftaran.</p>
        </div>
    </div>
</x-guest-layout>