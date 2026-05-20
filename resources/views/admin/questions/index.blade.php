{{-- Ini cuma tampilan statis, nanti sesuaikan aja sama backendnya --}}

<x-admin-layout title="Validasi Kuesioner Diagnostik">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-800">Validasi Kuesioner Diagnostik</h2>
                <span class="px-2 py-0.5 text-[10px] font-bold bg-rose-50 text-rose-500 border border-rose-100 rounded uppercase tracking-wider">
                    Belum Diverifikasi
                </span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Tinjau dan verifikasi setiap pertanyaan sebelum digunakan</p>
        </div>
        <button class="flex items-center px-5 py-2.5 bg-[#0d7a70] text-white text-sm font-bold rounded-xl hover:bg-[#0a635b] transition-all shadow-sm shadow-teal-100">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Konfirmasi Kuesioner
        </button>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-100 mb-8 shadow-sm">
        <div class="flex justify-between items-end mb-3">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Progress Validasi</span>
            <span class="text-[11px] font-bold text-emerald-500 uppercase tracking-widest">14 dari 21 pertanyaan sudah dicek</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
            <div class="bg-emerald-400 h-full rounded-full transition-all duration-1000" style="width: 66%"></div>
        </div>
    </div>

    <div x-data="{ activeAccordion: 1 }" class="space-y-4">
        
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <button @click="activeAccordion = activeAccordion === 1 ? null : 1" 
                    class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Emosi (7 Pertanyaan)</h3>
                </div>
                <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="activeAccordion === 1" x-collapse>
                <div class="p-6 pt-0 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-5 border border-slate-100 rounded-xl bg-slate-50/30 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex gap-2">
                                    <span class="px-2 py-1 bg-white border border-slate-200 rounded text-[9px] font-bold text-slate-400">Q-01</span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-500 rounded text-[9px] font-bold">Emosi</span>
                                </div>
                                <span class="text-[9px] font-bold text-emerald-500 uppercase">Sudah Dicek</span>
                            </div>
                            <p class="text-sm font-medium text-slate-700 leading-relaxed mb-6">
                                Seberapa sering Anda merasa sedih atau hampa dalam 2 minggu terakhir?
                            </p>
                        </div>
                        <a href="#" class="text-xs font-bold text-[#0d7a70] flex items-center justify-end hover:underline">
                            Lihat Detail
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>

                    <div class="p-5 border border-slate-100 rounded-xl bg-white shadow-sm flex flex-col justify-between border-l-4 border-l-rose-400">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex gap-2">
                                    <span class="px-2 py-1 bg-white border border-slate-200 rounded text-[9px] font-bold text-slate-400">Q-02</span>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-500 rounded text-[9px] font-bold">Emosi</span>
                                </div>
                                <span class="text-[9px] font-bold text-rose-400 uppercase tracking-wider">Belum Dicek</span>
                            </div>
                            <p class="text-sm font-medium text-slate-700 leading-relaxed mb-6">
                                Apakah Anda kehilangan minat pada aktivitas yang biasanya Anda nikmati?
                            </p>
                        </div>
                        <a href="#" class="text-xs font-bold text-[#0d7a70] flex items-center justify-end hover:underline">
                            Lihat Detail
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <button @click="activeAccordion = activeAccordion === 2 ? null : 2" 
                    class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Kognitif (7 Pertanyaan)</h3>
                </div>
                <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="activeAccordion === 2" x-collapse class="p-6 pt-0 text-slate-400 text-sm italic">
                Data pertanyaan kognitif belum tersedia...
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <button @click="activeAccordion = activeAccordion === 3 ? null : 3" 
                    class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Fisik (7 Pertanyaan)</h3>
                </div>
                <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="activeAccordion === 3" x-collapse class="p-6 pt-0 text-slate-400 text-sm italic">
                Data pertanyaan fisik belum tersedia...
            </div>
        </div>

    </div>
</x-admin-layout>