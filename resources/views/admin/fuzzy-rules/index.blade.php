{{-- Ini cuma tampilan statis, nanti sesuaikan aja sama backendnya --}}

<x-admin-layout title="Manajemen Aturan (Sistem Pakar)">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen Aturan (Sistem Pakar)</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola logika "JIKA... MAKA..." untuk asesmen diagnostik.</p>
        </div>
        <button class="flex items-center px-5 py-2.5 bg-[#0d7a70] text-white text-sm font-bold rounded-xl hover:bg-[#0a635b] transition-all shadow-sm shadow-teal-100">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Aturan Baru
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="p-4 bg-emerald-50 rounded-xl text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 block mb-0.5">Total Aturan</span>
                <span class="text-2xl font-bold text-slate-800">42</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="p-4 bg-rose-50 rounded-xl text-rose-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 block mb-0.5">Aturan Non-aktif</span>
                <span class="text-2xl font-bold text-slate-800">3</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="p-4 bg-blue-50 rounded-xl text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 block mb-0.5">Pembaruan Terakhir</span>
                <span class="text-lg font-bold text-slate-800">Hari ini, 09:41</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-6">
        <div class="relative w-full md:w-96">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" placeholder="Cari ID Aturan, Kondisi, atau Kesimpulan..." 
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:border-[#0d7a70] focus:ring-1 focus:ring-[#0d7a70] focus:outline-none transition-all placeholder-slate-400">
        </div>
        
        <div class="flex gap-3 w-full md:w-auto">
            <button class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all w-full md:w-auto">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filter
            </button>
            <button class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all w-full md:w-auto">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                </svg>
                Urutkan
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider bg-slate-50/50">
                        <th class="py-4 px-6 w-20">ID</th>
                        <th class="py-4 px-6 w-1/2">Kondisi (JIKA)</th>
                        <th class="py-4 px-6">Kesimpulan (MAKA)</th>
                        <th class="py-4 px-6 w-28">Status</th>
                        <th class="py-4 px-6 w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-5 px-6 font-bold text-slate-800">R001</td>
                        <td class="py-5 px-6">
                            <div class="flex flex-col gap-2 items-start">
                                <span class="px-2.5 py-1 bg-slate-100 rounded text-xs font-medium text-slate-600">P01: Kehilangan minat (Sering)</span>
                                <span class="text-[10px] font-bold text-slate-400 tracking-wider pl-2">AND</span>
                                <span class="px-2.5 py-1 bg-slate-100 rounded text-xs font-medium text-slate-600">P02: Merasa sedih (Sering)</span>
                            </div>
                        </td>
                        <td class="py-5 px-6 font-bold text-emerald-600">Depresi Mayor</td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-500 border border-emerald-100">Aktif</span>
                        </td>
                        <td class="py-5 px-6 text-center">
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-[#0d7a70] hover:border-teal-200 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 01-6 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </button>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-5 px-6 font-bold text-slate-800">R002</td>
                        <td class="py-5 px-6">
                            <div class="flex flex-col gap-2 items-start">
                                <span class="px-2.5 py-1 bg-slate-100 rounded text-xs font-medium text-slate-600">P03: Sulit tidur (Kadang)</span>
                                <span class="text-[10px] font-bold text-slate-400 tracking-wider pl-2">OR</span>
                                <span class="px-2.5 py-1 bg-slate-100 rounded text-xs font-medium text-slate-600">P04: Nafsu makan turun (Kadang)</span>
                            </div>
                        </td>
                        <td class="py-5 px-6 font-bold text-emerald-600">Gejala Ringan</td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-500 border border-emerald-100">Aktif</span>
                        </td>
                        <td class="py-5 px-6 text-center">
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-[#0d7a70] hover:border-teal-200 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 01-6 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </button>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-5 px-6 font-bold text-slate-800">R003</td>
                        <td class="py-5 px-6">
                            <div class="flex flex-col gap-2 items-start">
                                <span class="px-2.5 py-1 bg-slate-100 rounded text-xs font-medium text-slate-600">P05: Kelelahan ekstrim (Selalu)</span>
                            </div>
                        </td>
                        <td class="py-5 px-6 font-bold text-slate-500">Evaluasi Lanjut</td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-400 border border-slate-200">Non-aktif</span>
                        </td>
                        <td class="py-5 px-6 text-center">
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-[#0d7a70] hover:border-teal-200 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 01-6 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-slate-500">
        <span>Menampilkan 1-3 dari 42 aturan</span>
        <div class="flex items-center gap-1">
            <button class="p-2 border border-slate-200 rounded-xl hover:bg-slate-50 disabled:opacity-40 transition-all" disabled>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="w-9 h-9 bg-[#0d7a70] text-white font-bold rounded-xl text-xs transition-all">1</button>
            <button class="w-9 h-9 border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold rounded-xl text-xs transition-all">2</button>
            <button class="w-9 h-9 border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold rounded-xl text-xs transition-all">3</button>
            <button class="p-2 border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>
</x-admin-layout>