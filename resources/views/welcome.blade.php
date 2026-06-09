<x-landing-layout>

    <x-slot name="title">Beranda | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

    <div class="w-full bg-white selection:bg-[#0d7a70] selection:text-white">
        
        <nav class="max-w-6xl mx-auto px-6 py-5 flex justify-between items-center">
            <div class="flex items-center space-x-10">
                <span class="text-xl font-bold text-[#0d7a70] tracking-tight">DepreSense</span>
                <div class="hidden md:flex space-x-6 text-sm font-medium text-slate-600">
                    <a href="#" class="text-[#0d7a70] border-b-2 border-[#0d7a70] pb-1">Beranda</a>
                    <!-- <a href="#" class="hover:text-[#0d7a70] transition">Assessment</a> -->
                </div>
            </div>
            <div>
                <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-[#0d7a70] hover:bg-[#0a5c54] rounded-full transition shadow-sm">
                    Login
                </a>
            </div>
        </nav>

        <header class="max-w-6xl mx-auto px-6 pt-10 pb-20 grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
            <div class="md:col-span-7 space-y-6">
                <span class="inline-block px-3 py-1 bg-orange-50 text-orange-600 text-xs font-semibold rounded-md tracking-wide">
                    DepreSense Mengutamakan Kesejahteraan Mental Mahasiswa
                </span>
                
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
                    <!-- <a href="{{ route('register') }}" class="px-6 py-3.5 bg-blue-50 hover:bg-blue-100 text-[#0d7a70] font-semibold rounded-full transition text-sm">
                        Pelajari PASSI
                    </a> -->
                </div>

                <div class="flex flex-wrap gap-6 text-xs text-slate-400 pt-4 border-t border-slate-100">
                    <div class="flex items-center space-x-1.5">
                        <span class="text-[#0d7a70]">✓</span> <span>Validasi Skala</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <span class="text-[#0d7a70]">✓</span> <span>Privasi Terjaga</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <span class="text-[#0d7a70]">✓</span> <span>Gratis untuk Mahasiswa</span>
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 flex justify-center md:justify-end">
                <div class="w-full max-w-[360px] aspect-[4/5] bg-slate-100 rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-200/60 relative">
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 pt-4">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-12 h-12 rounded-full border-2 border-[#0d7a70] bg-white flex items-center justify-center font-bold text-[#0d7a70] text-sm">
                        1
                    </div>
                    <h4 class="font-bold text-slate-700 text-sm">Mulai</h4>
                    <p class="text-slate-400 text-[11px] max-w-[200px] leading-relaxed">Klik tombol mulai tanpa perlu pendaftaran awal yang rumit.</p>
                </div>

                <div class="flex flex-col items-center space-y-3">
                    <div class="w-12 h-12 rounded-full border-2 border-[#0d7a70] bg-white flex items-center justify-center font-bold text-[#0d7a70] text-sm">
                        2
                    </div>
                    <h4 class="font-bold text-slate-700 text-sm">Isi Kuesioner</h4>
                    <p class="text-slate-400 text-[11px] max-w-[200px] leading-relaxed">Jawab 21 pertanyaan tentang kebiasaan akademik & keadaan emosional Anda.</p>
                </div>

                <div class="flex flex-col items-center space-y-3">
                    <div class="w-12 h-12 rounded-full border-2 border-[#0d7a70] bg-white flex items-center justify-center font-bold text-[#0d7a70] text-sm">
                        3
                    </div>
                    <h4 class="font-bold text-slate-700 text-sm">Proses Otomatis</h4>
                    <p class="text-slate-400 text-[11px] max-w-[200px] leading-relaxed">Sistem kami menganalisis jawaban Anda menggunakan algoritma BDI-II.</p>
                </div>

                <div class="flex flex-col items-center space-y-3">
                    <div class="w-12 h-12 rounded-full border-2 border-[#0d7a70] bg-white flex items-center justify-center font-bold text-[#0d7a70] text-sm">
                        4
                    </div>
                    <h4 class="font-bold text-slate-700 text-sm">Lihat Hasil</h4>
                    <p class="text-slate-400 text-[11px] max-w-[200px] leading-relaxed">Dapatkan skor emosional dan rekomendasi tindakan personal segera.</p>
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
                            Bukan diagnosis medis. Hasil ini ditujukan untuk edukasi dan screening awal sebagai bentuk kesadaran diri.
                        </p>
                    </div>
                    
                    <div class="w-full lg:w-auto flex justify-start lg:justify-end lg:w-1/4">
                        <a href="{{ route('screening.consent') }}" class="w-full lg:w-auto px-5 py-2.5 bg-[#0d7a70] hover:bg-[#0a5c54] text-white text-xs font-bold rounded-full transition shadow-sm flex items-center justify-center space-x-2 active:scale-95">
                            <span>Mulai Tes Sekarang</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
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