@if(auth()->check())
    <x-app-layout>
@else
    <x-guest-layout maxWidth="sm:max-w-3xl">
@endif
    <div class="text-center mb-10 mt-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-rose-50 text-rose-600 mb-6 border border-rose-100 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
        
        <h2 class="text-3xl font-extrabold text-slate-800 mb-4">Anda Tidak Sendirian</h2>
        
        <p class="text-slate-600 text-lg leading-relaxed max-w-2xl mx-auto">
            Kami memahami bahwa saat ini mungkin terasa sangat berat. Keselamatan dan kesejahteraan Anda adalah prioritas. Jangan ragu untuk <strong>menjangkau bantuan profesional</strong> yang siap mendengarkan Anda.
        </p>
    </div>

    <div class="mb-10 bg-white rounded-[2rem] border border-rose-100 overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
        <div class="px-8 py-5 border-b border-rose-50 bg-rose-50/50">
            <h4 class="font-bold text-rose-800 flex items-center">
                <svg class="w-5 h-5 mr-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Pusat Bantuan Krisis (Gratis & Rahasia)
            </h4>
        </div>
        <div class="p-8">
            <ul class="space-y-4">
                <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="mb-3 sm:mb-0">
                        <strong class="block text-slate-800 font-bold">Kemenkes RI (Sejiwa)</strong>
                        <span class="text-sm text-slate-500">Layanan Psikologis Bantuan Kejiwaan (24 Jam)</span>
                    </div>
                    <a href="tel:119" class="inline-flex justify-center font-bold px-6 py-2 bg-rose-100 text-rose-700 rounded-xl hover:bg-rose-200 transition-colors">
                        📞 119 (Ext 8)
                    </a>
                </li>
                
                <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="mb-3 sm:mb-0">
                        <strong class="block text-slate-800 font-bold">Layanan Konseling Mahasiswa</strong>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="text-center mb-8">
        <p class="text-slate-500 text-sm">
            Harap ingat bahwa ada banyak orang yang bersedia membantu Anda melewati masa sulit ini.
        </p>
    </div>

    <div class="text-center mt-4">
        <a href="{{ auth()->check() ? route('user.dashboard') : route('home') }}" class="inline-flex justify-center items-center px-6 py-2 text-sm font-semibold text-slate-400 hover:text-rose-600 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
@if(auth()->check())
    </x-app-layout>
@else
    </x-guest-layout>
@endif