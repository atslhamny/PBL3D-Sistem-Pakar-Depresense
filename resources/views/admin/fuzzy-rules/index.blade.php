<x-admin-layout title="Aturan Fuzzy Mamdani">
    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Aturan Fuzzy Mamdani</h2>
            <p class="text-slate-500 mt-1">Konfigurasi logika inferensi untuk penentuan tingkat depresi.</p>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.03)] p-12 flex flex-col items-center justify-center min-h-[400px]">
        
        <!-- Icon Stage -->
        <div class="mb-6 p-6 bg-[#f0f9fa] rounded-full">
            <svg class="w-16 h-16 text-[#0d7a70]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
            </svg>
        </div>

        <!-- Alert Modul Pengembangan -->
        <div class="max-w-md text-center">
            <h3 class="text-xl font-bold text-slate-800 mb-2">Modul Sedang Disiapkan</h3>
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 border border-amber-100 text-amber-600 text-[10px] font-bold uppercase tracking-wider mb-4">
                Under Development
            </div>
            <p class="text-sm text-slate-500 leading-relaxed mb-8">
                Modul Aturan Fuzzy Mamdani saat ini masih dalam tahap pengembangan backend. Fitur untuk mengatur basis aturan (*rule base*) akan segera tersedia.
            </p>
            
            <!-- Action Button -->
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-[#0d7a70] text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-[#0a635b] transition-all shadow-lg shadow-[#0d7a70]/20 hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</x-admin-layout>