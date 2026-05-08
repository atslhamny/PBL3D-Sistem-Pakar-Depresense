<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->full_name }}!</h3>
                    <p class="text-gray-500 dark:text-gray-400">Pantau kondisi kesehatan mental Anda secara berkala.</p>
                </div>
            </div>

            @if($latestSession)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <h4 class="font-bold text-lg mb-4 text-gray-800 dark:text-white">Hasil Assessment Terakhir</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-4 rounded-xl border border-indigo-100 dark:border-indigo-800">
                                <span class="block text-sm text-indigo-600 dark:text-indigo-400 font-semibold mb-1">Tingkat Indikasi</span>
                                <span class="text-2xl font-black capitalize text-indigo-700 dark:text-indigo-300">{{ $latestSession->depression_level->value }}</span>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-xl border border-slate-200 dark:border-slate-600">
                                <span class="block text-sm text-slate-500 dark:text-slate-400 font-semibold mb-1">Tanggal Assessment</span>
                                <span class="text-lg font-bold text-slate-700 dark:text-slate-200">{{ $latestSession->completed_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-xl border border-slate-200 dark:border-slate-600">
                                <span class="block text-sm text-slate-500 dark:text-slate-400 font-semibold mb-1">Total Skor BDI-II</span>
                                <span class="text-lg font-bold text-slate-700 dark:text-slate-200">{{ $latestSession->score_total }}</span>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('screening.consent') }}" class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors shadow-sm">
                                Lakukan Assessment Ulang
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/50 overflow-hidden shadow-sm sm:rounded-xl text-center py-12">
                    <div class="p-6">
                        <svg class="mx-auto h-12 w-12 text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum Ada Riwayat Assessment</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Mulai assessment pertama Anda untuk mengetahui kondisi kesehatan mental.</p>
                        <a href="{{ route('screening.consent') }}" class="inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none transition-colors shadow-sm">
                            Mulai Assessment
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
