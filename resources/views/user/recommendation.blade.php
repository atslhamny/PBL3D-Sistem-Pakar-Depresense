<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rekomendasi Lanjutan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($latestSession)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Rekomendasi Berdasarkan Assessment Terakhir</h3>
                            <span class="text-sm text-gray-500">{{ $latestSession->completed_at->format('d M Y') }}</span>
                        </div>
                        
                        <div class="p-6 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl mb-6 border border-indigo-100 dark:border-indigo-800">
                            <span class="block text-sm text-indigo-600 dark:text-indigo-400 font-semibold mb-1 uppercase tracking-wider">Tingkat Indikasi Anda</span>
                            <span class="text-2xl font-black capitalize text-indigo-800 dark:text-indigo-300">{{ $latestSession->depression_level->value }}</span>
                        </div>

                        <ul class="space-y-4">
                            @foreach($recommendations as $rec)
                                <li class="flex items-start bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                    <svg class="w-6 h-6 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-gray-700 dark:text-gray-300 text-lg">{{ $rec }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/50 overflow-hidden shadow-sm sm:rounded-xl text-center py-12">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum Ada Riwayat Assessment</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Mulai assessment pertama Anda untuk mendapatkan rekomendasi penanganan.</p>
                        <a href="{{ route('screening.consent') }}" class="inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none transition-colors shadow-sm">
                            Mulai Assessment
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
