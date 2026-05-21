<x-app-layout>
    {{-- Bagian Atas: Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Pusat Bantuan & Edukasi</h2>
        <p class="text-slate-500 text-sm mt-1">Temukan berbagai sumber daya, panduan praktis, dan bantuan profesional untuk mendukung kesehatan mental Anda.</p>
    </div>

    {{-- Grid Konten Utama --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Kolom Kiri & Tengah: Latihan & Artikel --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Card: Latihan Pernafasan Interaktif (4-7-8 Technique) --}}
            <div class="bg-gradient-to-br from-[#0d7a70] to-[#0a635b] text-white p-8 rounded-[2rem] shadow-lg relative overflow-hidden">
                <div class="absolute right-0 bottom-0 opacity-10 translate-x-10 translate-y-10">
                    <svg class="w-72 h-72" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15.5h-2v-2h2v2zm0-4.5h-2V7h2v6z"/>
                    </svg>
                </div>
                
                <div class="relative z-10">
                    <span class="bg-white/20 text-white text-[10px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider inline-block mb-4">Latihan Relaksasi</span>
                    <h3 class="text-2xl font-extrabold mb-2">Metode Pernapasan Kotak (4-4-4)</h3>
                    <p class="text-teal-50 text-sm leading-relaxed mb-6 max-w-md">Latihan pernapasan sederhana namun sangat efektif untuk merilekskan sistem saraf Anda secara instan saat merasa cemas atau stres.</p>
                    
                    {{-- Visualizer Animasi Sederhana --}}
                    <div class="flex items-center space-x-6 p-4 bg-white/10 rounded-2xl backdrop-blur-sm max-w-md" x-data="{ state: 'Mulai', count: 0, timer: null, running: false,
                        startBreath() {
                            if (this.running) {
                                clearInterval(this.timer);
                                this.running = false;
                                this.state = 'Mulai';
                                this.count = 0;
                                return;
                            }
                            this.running = true;
                            this.state = 'Tarik Nafas';
                            this.count = 4;
                            this.timer = setInterval(() => {
                                this.count--;
                                if (this.count <= 0) {
                                    if (this.state === 'Tarik Nafas') {
                                        this.state = 'Tahan Nafas';
                                        this.count = 4;
                                    } else if (this.state === 'Tahan Nafas') {
                                        this.state = 'Hembuskan';
                                        this.count = 4;
                                    } else {
                                        this.state = 'Tarik Nafas';
                                        this.count = 4;
                                    }
                                }
                            }, 1000);
                        }
                    }">
                        <div class="relative flex items-center justify-center h-16 w-16 bg-white text-[#0d7a70] rounded-full font-bold shadow-md cursor-pointer hover:scale-105 transition-transform"
                             @click="startBreath()">
                            <svg x-show="!running" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <svg x-show="running" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" style="display:none;">
                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-teal-150 uppercase tracking-widest" x-text="running ? 'Ikuti petunjuk' : 'Tekan tombol play untuk memulai'"></p>
                            <h4 class="text-xl font-bold transition-all" x-text="running ? state + ' (' + count + 's)' : 'Mulai Latihan 1 Menit'"></h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Artikel & Panduan Edukatif --}}
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#0d7a70]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Artikel Edukasi Pilihan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Card Artikel 1 --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-[#0d7a70] bg-[#f0f9fa] px-2.5 py-1 rounded-full uppercase tracking-wider">Self-Care</span>
                            <h4 class="text-base font-bold text-slate-800 mt-3 group-hover:text-[#0d7a70] transition-colors">Cara Praktis Mengelola Stres Akademik</h4>
                            <p class="text-slate-500 text-xs mt-2 leading-relaxed">Stres akibat tugas dan ujian adalah hal biasa bagi mahasiswa. Simak 5 langkah terbukti untuk mengorganisir jadwal belajar...</p>
                        </div>
                        <a href="#" class="text-xs font-semibold text-[#0d7a70] hover:underline mt-4 flex items-center">
                            Baca Selengkapnya
                            <svg class="w-3 h-3 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>

                    {{-- Card Artikel 2 --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full uppercase tracking-wider">Mindfulness</span>
                            <h4 class="text-base font-bold text-slate-800 mt-3 group-hover:text-purple-600 transition-colors">Melatih Kehadiran Diri dengan Meditasi</h4>
                            <p class="text-slate-500 text-xs mt-2 leading-relaxed">Menjaga fokus pada saat ini (mindfulness) membantu meredakan overthinking dan kecemasan tentang masa depan...</p>
                        </div>
                        <a href="#" class="text-xs font-semibold text-[#0d7a70] hover:underline mt-4 flex items-center">
                            Baca Selengkapnya
                            <svg class="w-3 h-3 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Bantuan Profesional & Helpline Darurat --}}
        <div class="space-y-8">
            {{-- Layanan Konseling & Helpline --}}
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Bantuan & Kontak Darurat
                </h3>
                <p class="text-slate-400 text-xs mb-6">Jika Anda atau seseorang yang Anda kenal membutuhkan bantuan segera, hubungi layanan berikut.</p>
                
                <div class="space-y-4">
                    {{-- Layanan 1 --}}
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <h4 class="text-xs font-bold text-slate-700">Layanan Konseling Kampus</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Senin - Jumat, 08:00 - 16:00 WIB</p>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-200/60">
                            <span class="text-xs font-semibold text-slate-800">Gedung Pusat Mahasiswa Lt. 2</span>
                            <a href="tel:0211234567" class="text-xs font-bold text-[#0d7a70] hover:underline flex items-center">
                                Hubungi
                            </a>
                        </div>
                    </div>

                    {{-- Layanan 2 --}}
                    <div class="p-4 bg-rose-50/50 rounded-2xl border border-rose-100/50">
                        <h4 class="text-xs font-bold text-rose-700">Kementerian Kesehatan (Sejiwa)</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Layanan Kesehatan Jiwa Nasional Kemenkes</p>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-rose-100">
                            <span class="text-xs font-bold text-rose-600">Hotline 119 (Ext. 8)</span>
                            <a href="tel:119" class="text-xs font-bold text-rose-700 hover:underline flex items-center">
                                Hubungi
                            </a>
                        </div>
                    </div>

                    {{-- Layanan 3 --}}
                    <div class="p-4 bg-amber-50/40 rounded-2xl border border-amber-100/40">
                        <h4 class="text-xs font-bold text-amber-800">Into The Light Indonesia</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Komunitas Pencegahan Bunuh Diri & Konseling</p>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-amber-100/60">
                            <span class="text-xs font-semibold text-slate-700">intothelightid.org</span>
                            <a href="https://www.intothelightid.org" target="_blank" class="text-xs font-bold text-amber-800 hover:underline flex items-center">
                                Kunjungi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips Jurnal Harian Pendukung --}}
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between min-h-[160px]">
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 block">Kata Bijak Hari Ini</h4>
                    <p class="text-sm italic text-slate-600 leading-relaxed">"Merawat kesehatan mental Anda bukanlah tindakan egois, melainkan pondasi untuk bisa bertumbuh dan menolong sesama."</p>
                </div>
                <div class="text-[10px] text-slate-400 font-medium pt-4 border-t border-slate-50">
                    DepreSense Digital Sanctuary
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
