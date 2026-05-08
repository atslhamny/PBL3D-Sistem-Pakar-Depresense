<x-guest-layout>
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-100 text-red-600 mb-6 border-4 border-red-50 dark:bg-red-900/50 dark:text-red-400 dark:border-red-900/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        
        <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-4">Kami Peduli Pada Anda</h2>
        
        <p class="text-slate-600 dark:text-slate-300 text-lg mb-8 leading-relaxed">
            Berdasarkan respon yang Anda berikan, sistem mendeteksi adanya beban emosional yang berat dan pemikiran yang berisiko. Kami sangat menyarankan Anda untuk <strong>segera menghubungi profesional atau orang terdekat</strong>.
        </p>

        <div class="bg-red-50 dark:bg-red-900/20 rounded-2xl p-6 border border-red-100 dark:border-red-900/50 text-left mb-8 shadow-sm">
            <h3 class="text-red-800 dark:text-red-300 font-bold mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                Layanan Bantuan Krisis (24 Jam)
            </h3>
            <ul class="space-y-4 text-red-700 dark:text-red-400">
                <li class="flex justify-between items-center bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-red-100 dark:border-red-900/30">
                    <div>
                        <strong class="block text-red-900 dark:text-red-200">Kemenkes RI (Sejiwa)</strong>
                        <span class="text-sm">Layanan Psikologis Bantuan Kejiwaan</span>
                    </div>
                    <a href="tel:119" class="font-bold text-xl px-4 py-2 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-800/80 transition-colors">119 (Ext 8)</a>
                </li>
                <li class="flex justify-between items-center bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-red-100 dark:border-red-900/30">
                    <div>
                        <strong class="block text-red-900 dark:text-red-200">Layanan Darurat Polisi</strong>
                        <span class="text-sm">Jika berada dalam kondisi sangat kritis</span>
                    </div>
                    <a href="tel:110" class="font-bold text-xl px-4 py-2 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-800/80 transition-colors">110</a>
                </li>
            </ul>
        </div>

        <p class="text-slate-500 dark:text-slate-400 text-sm mb-8">
            Harap ingat bahwa Anda tidak sendirian. Ada banyak orang yang bersedia membantu Anda melewati masa sulit ini.
        </p>

        <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm text-base font-medium text-slate-700 bg-white hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 focus:outline-none transition-all">
            Kembali ke Beranda
        </a>
    </div>
</x-guest-layout>
