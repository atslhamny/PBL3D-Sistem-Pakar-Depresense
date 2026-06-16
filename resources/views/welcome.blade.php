<x-landing-layout>

    <x-slot name="title">Beranda | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

    <div class="w-full bg-white selection:bg-[#0d7a70] selection:text-white">
        
        <nav class="max-w-6xl mx-auto px-6 py-5 flex justify-between items-center">
            <div class="flex items-center space-x-10">
                <span class="text-xl font-bold text-[#0d7a70] tracking-tight">DepreSense</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-[#0d7a70] hover:bg-[#0a5c54] rounded-full transition shadow-sm">
                    Login
                </a>
            </div>
        </nav>

        <header class="max-w-6xl mx-auto px-6 pt-10 pb-20 flex flex-col md:flex-row gap-10 items-center justify-between">
            <div class="w-full md:w-3/5 space-y-6">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-[1.15]">
                    Saatnya Memahami <br>
                    <span class="text-[#0d7a70]">Perasaanmu Lebih Jujur</span>
                </h1>
                
                <p class="text-slate-500 text-sm leading-relaxed max-w-lg">
                    Sistem Pakar Deteksi Dini Depresi. Menganalisis dan mendeteksi potensi tingkat depresi secara akurat menggunakan kuesioner klinis <strong>BDI-II</strong> (21 item, hanya 5 menit) untuk mendapatkan hasil instan dan rekomendasi langkah selanjutnya.
                </p>
                
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('screening.consent') }}" class="px-6 py-3.5 bg-[#0d7a70] hover:bg-[#0a5c54] text-white font-semibold rounded-full transition shadow-md flex items-center space-x-2 text-sm">
                        <span>Mulai Assessment</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <div class="flex flex-wrap gap-6 text-xs font-semibold text-slate-500 pt-4 border-t border-slate-100">
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-[#0d7a70]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>Validated Scale</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-[#0d7a70]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        <span>Privasi Terjaga</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-[#0d7a70]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
                        <span>Gratis untuk Mahasiswa</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/5 flex justify-center md:justify-end">
                <div class="w-full max-w-[280px] lg:max-w-[320px] aspect-[4/5] bg-slate-100 rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-200/60 relative" style="max-width: 320px; aspect-ratio: 4/5;">
                    <img src="{{ asset('images/landing_hero.webp') }}" 
                         alt="Mahasiswa DepreSense Wellness" 
                         class="w-full h-full object-cover object-center transform hover:scale-105 transition duration-700"
                         loading="eager"
                         fetchpriority="high"
                         decoding="async">
                </div>
            </div>
        </header>

        <section class="bg-slate-100 py-16 px-6 border-y border-slate-200/60">
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100/80 space-y-4 transition-all hover:shadow-md">
                    <div class="w-10 h-10 bg-teal-50 rounded-full flex items-center justify-center text-[#0d7a70]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">5 Menit</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Dirancang untuk kecepatan tanpa mengabaikan kualitas. Cocok untuk jadwal kuliah yang padat.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100/80 space-y-4 transition-all hover:shadow-md">
                    <div class="w-10 h-10 bg-orange-50 rounded-full flex items-center justify-center text-orange-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">21 Item</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Berbasis Beck Depression Inventory-II (BDI-II) yang telah divalidasi secara akademis dan klinis.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100/80 space-y-4 transition-all hover:shadow-md">
                    <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Privasi</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Data Anda dienkripsi. Hasil assessment bersifat anonim dan hanya Anda yang memiliki akses penuh.
                    </p>
                </div>

            </div>
        </section>

        <section class="max-w-6xl mx-auto px-6 py-20 text-center space-y-14">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-slate-800">Bagaimana DepreSense Bekerja?</h2>
                <p class="text-slate-400 text-xs max-w-lg mx-auto">
                    Proses sederhana untuk memahami kondisi emosional dan prokrastinasi akademik Anda.
                </p>
            </div>

            <div class="relative pt-4 max-w-4xl mx-auto">
                <div class="grid grid-cols-4 gap-2 sm:gap-6 lg:gap-8 relative z-10" style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr));">
                    <div class="flex flex-col items-center space-y-2 sm:space-y-3 text-center">
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full border-2 border-[#0d7a70] bg-white flex items-center justify-center font-bold text-[#0d7a70] text-xs sm:text-sm shadow-sm relative z-10">
                            1
                        </div>
                        <h4 class="font-bold text-slate-700 text-[10px] sm:text-sm mt-2">Mulai</h4>
                        <p class="text-slate-400 text-[9px] sm:text-[11px] max-w-[200px] leading-relaxed hidden sm:block">Klik tombol mulai tanpa perlu pendaftaran awal yang rumit.</p>
                    </div>

                    <div class="flex flex-col items-center space-y-2 sm:space-y-3 text-center">
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full border-2 border-[#0d7a70] bg-white flex items-center justify-center font-bold text-[#0d7a70] text-xs sm:text-sm shadow-sm relative z-10">
                            2
                        </div>
                        <h4 class="font-bold text-slate-700 text-[10px] sm:text-sm mt-2">Isi Kuesioner</h4>
                        <p class="text-slate-400 text-[9px] sm:text-[11px] max-w-[200px] leading-relaxed hidden sm:block">Jawab 21 pertanyaan tentang kebiasaan akademik & keadaan emosional Anda.</p>
                    </div>

                    <div class="flex flex-col items-center space-y-2 sm:space-y-3 text-center">
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full border-2 border-[#0d7a70] bg-white flex items-center justify-center font-bold text-[#0d7a70] text-xs sm:text-sm shadow-sm relative z-10">
                            3
                        </div>
                        <h4 class="font-bold text-slate-700 text-[10px] sm:text-sm mt-2">Proses Otomatis</h4>
                        <p class="text-slate-400 text-[9px] sm:text-[11px] max-w-[200px] leading-relaxed hidden sm:block">Sistem kami menganalisis jawaban Anda menggunakan algoritma BDI-II.</p>
                    </div>

                    <div class="flex flex-col items-center space-y-2 sm:space-y-3 text-center">
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full border-2 border-[#0d7a70] bg-white flex items-center justify-center font-bold text-[#0d7a70] text-xs sm:text-sm shadow-sm relative z-10">
                            4
                        </div>
                        <h4 class="font-bold text-slate-700 text-[10px] sm:text-sm mt-2">Lihat Hasil</h4>
                        <p class="text-slate-400 text-[9px] sm:text-[11px] max-w-[200px] leading-relaxed hidden sm:block">Dapatkan skor emosional dan rekomendasi tindakan personal segera.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-slate-100 border-t border-slate-200/60 mt-auto py-8 px-6">
            <div class="max-w-6xl mx-auto space-y-6">
                
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    
                    <div class="space-y-0.5 lg:w-1/7">
                        <span class="text-base font-bold text-[#0d7a70] tracking-tight block">DepreSense</span>
                        <span class="text-[11px] text-slate-400 block">© 2026 DepreSense Digital Sanctuary</span>
                    </div>

                    <div class="w-full lg:w-auto max-w-xl bg-[#111827] text-slate-300 rounded-full px-5 py-2.5 shadow-sm flex items-center space-x-3 border border-slate-800/80 mx-auto lg:mx-0">
                        <div class="flex-shrink-0 w-4 h-4 bg-orange-600 rounded-full flex items-center justify-center text-white text-[10px] font-black">
                            !
                        </div>
                        <p class="text-[10px] md:text-[11px] leading-snug tracking-wide">
                            <strong class="text-orange-500 font-bold uppercase tracking-wider">DISCLAIMER:</strong> 
                            Bukan diagnosis medis. Hasil ini ditujukan untuk screening awal sebagai bentuk kesadaran diri.
                        </p>
                    </div>
                    
                    <div class="w-full lg:w-auto flex justify-start lg:justify-end lg:w-1/4">
                    </div>

                </div>

                <div class="border-t border-slate-200/60 pt-4">
                    <p class="text-[11px] text-slate-400 italic leading-relaxed">
                        *Hasil akan disimpan secara aman dan Anda dapat melihat riwayat perkembangan jika melakukan pendaftaran.
                    </p>
                </div>

            </div>
        </footer>

    </div>
</x-landing-layout>