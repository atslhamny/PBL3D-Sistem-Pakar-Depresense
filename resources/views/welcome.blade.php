<x-guest-layout>
    <div class="text-center">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Sistem Pakar Deteksi Dini Depresi</h2>
        <p class="text-slate-600 dark:text-slate-300 mb-8 text-sm leading-relaxed">
            DepreSense menggunakan metode Fuzzy Mamdani dan kuesioner klinis BDI-II untuk menganalisis dan mendeteksi potensi tingkat depresi secara akurat dan rahasia.
        </p>

        <div class="space-y-4">
            <a href="{{ route('screening.consent') }}" class="block w-full px-6 py-3.5 text-center text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl font-medium transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:scale-[1.02]">
                Mulai Assessment Tanpa Login
            </a>
            
            <div class="relative flex items-center py-2">
                <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
                <span class="flex-shrink-0 px-4 text-xs text-slate-400 dark:text-slate-500 uppercase font-semibold tracking-wider">Atau</span>
                <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('login') }}" class="px-6 py-3 text-center text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-xl font-medium transition-colors border border-indigo-100 dark:border-indigo-800">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-6 py-3 text-center text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl font-medium transition-colors border border-slate-200 dark:border-slate-600 shadow-sm">
                    Daftar Akun
                </a>
            </div>
        </div>

        <div class="mt-8 text-xs text-slate-500 dark:text-slate-400">
            *Hasil akan disimpan secara aman dan Anda dapat melihat riwayat perkembangan jika melakukan pendaftaran.
        </div>
    </div>
</x-guest-layout>
