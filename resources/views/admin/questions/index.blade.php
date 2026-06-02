<x-admin-layout title="Validasi Kuesioner Diagnostik">
    <div x-data="{ 
        activeAccordion: 1,
        showDetail: false,
        selectedQuestion: {
            item_number: '',
            question_text: '',
            category: '',
            sub_category: '',
            is_safety_item: false,
            answer_options: []
        },
        openDetail(q) {
            this.selectedQuestion = q;
            this.showDetail = true;
        }
    }" class="relative">

        <!-- Header Page & Title -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-slate-800">Validasi Kuesioner Diagnostik</h2>
                    <span class="px-2.5 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full uppercase tracking-wider">
                        Terverifikasi BDI-II
                    </span>
                </div>
                <p class="text-slate-500 text-sm mt-1">Tinjau instrumen penilaian Beck Depression Inventory-II (BDI-II) secara dinamis</p>
            </div>
            
            <div class="flex flex-col items-end gap-3">
                <a href="{{ route('admin.questions.create') }}" class="inline-flex items-center px-4 py-2 bg-[#0d7a70] text-white text-sm font-semibold rounded-xl hover:bg-[#0a635b] transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Pertanyaan
                </a>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold text-slate-400">Status Sistem:</span>
                    <span class="flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-100 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                        Aktif & Terkunci
                    </span>
                </div>
            </div>
        </div>

        <!-- Progress Validasi Dinamis -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 mb-8 shadow-sm">
            <div class="flex justify-between items-end mb-3">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Progress Verifikasi Instrumen</span>
                <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-widest">
                    {{ $checkedCount }} dari {{ $totalCount }} Pertanyaan Terkunci ({{ $progressPercent }}%)
                </span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                <div class="bg-emerald-400 h-full rounded-full transition-all duration-1000" style="width: {{ $progressPercent }}%"></div>
            </div>
        </div>

        <!-- Accordions -->
        <div class="space-y-4">
            
            <!-- Accordion 1: Kognitif & Afektif -->
            <div class="bg-white border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
                <button @click="activeAccordion = activeAccordion === 1 ? null : 1" 
                        class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="text-lg font-bold text-slate-800">Kognitif & Afektif</h3>
                            <p class="text-xs text-slate-400 font-medium">Mengukur aspek pikiran, perasaan hampa, rasa bersalah, dan emosi ({{ $cognitiveQuestions->count() }} Pertanyaan)</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="activeAccordion === 1" x-collapse>
                    <div class="p-6 pt-0 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($cognitiveQuestions as $q)
                            <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/40 hover:bg-white hover:shadow-md hover:border-emerald-100 transition-all flex flex-col justify-between group relative overflow-hidden">
                                @if($q->is_safety_item)
                                    <div class="absolute top-0 right-0 h-1.5 w-full bg-rose-400 animate-pulse"></div>
                                @endif
                                <div>
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex gap-2">
                                            <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[9px] font-bold text-slate-500 uppercase">Q-{{ sprintf('%02d', $q->item_number) }}</span>
                                            <span class="px-2.5 py-1 bg-teal-50 text-[#0d7a70] rounded-lg text-[9px] font-bold">Kognitif & Afektif</span>
                                        </div>
                                        @if($q->is_safety_item)
                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-600 rounded text-[9px] font-bold uppercase tracking-wider animate-pulse">Item Keselamatan</span>
                                        @else
                                            <span class="text-[9px] font-bold text-emerald-500 uppercase flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                Terkunci
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700 leading-relaxed mb-6 group-hover:text-slate-800 transition-colors">
                                        {{ $q->question_text }}
                                    </p>
                                </div>
                                <button @click="openDetail({{ json_encode($q) }})" 
                                        class="text-xs font-bold text-[#0d7a70] flex items-center justify-end hover:underline self-end focus:outline-none">
                                    Tinjau Opsi Jawaban
                                    <svg class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Accordion 2: Somatik -->
            <div class="bg-white border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
                <button @click="activeAccordion = activeAccordion === 2 ? null : 2" 
                        class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="text-lg font-bold text-slate-800">Somatik (Fisik)</h3>
                            <p class="text-xs text-slate-400 font-medium">Mengukur gejala klinis fisik seperti pola tidur, nafsu makan, kelelahan tubuh, dan energi ({{ $somaticQuestions->count() }} Pertanyaan)</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="activeAccordion === 2" x-collapse>
                    <div class="p-6 pt-0 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($somaticQuestions as $q)
                            <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/40 hover:bg-white hover:shadow-md hover:border-blue-100 transition-all flex flex-col justify-between group relative overflow-hidden">
                                <div>
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex gap-2">
                                            <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[9px] font-bold text-slate-500 uppercase">Q-{{ sprintf('%02d', $q->item_number) }}</span>
                                            <span class="px-2.5 py-1 bg-blue-50 text-blue-500 rounded-lg text-[9px] font-bold">Somatik</span>
                                        </div>
                                        <span class="text-[9px] font-bold text-emerald-500 uppercase flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            Terkunci
                                        </span>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700 leading-relaxed mb-6 group-hover:text-slate-800 transition-colors">
                                        {{ $q->question_text }}
                                    </p>
                                </div>
                                <button @click="openDetail({{ json_encode($q) }})" 
                                        class="text-xs font-bold text-blue-600 flex items-center justify-end hover:underline self-end focus:outline-none">
                                    Tinjau Opsi Jawaban
                                    <svg class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <!-- Pop-up Slide-Over Modal Detail (Alpine.js) -->
        <div x-show="showDetail" 
             class="fixed inset-0 overflow-hidden z-50" 
             style="display: none;" 
             x-transition>
            <div class="absolute inset-0 overflow-hidden">
                <!-- Overlay Keluar -->
                <div @click="showDetail = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

                <!-- Kontainer Panel -->
                <div class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                    <div x-show="showDetail" 
                         x-transition:enter="transform transition ease-in-out duration-300"
                         x-transition:enter-start="translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full"
                         class="w-screen max-w-md">
                         
                        <div class="h-full flex flex-col bg-white shadow-2xl rounded-l-[2rem] overflow-y-auto">
                            <!-- Header Modal -->
                            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 rounded-tl-[2rem]">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[10px] font-bold text-slate-500" x-text="'Q-' + String(selectedQuestion.item_number).padStart(2, '0')"></span>
                                        <span class="px-2.5 py-1 bg-[#ecf5f4] text-[#0d7a70] rounded-lg text-[9px] font-bold uppercase tracking-wider" x-text="selectedQuestion.sub_category === 'kognitif' ? 'Kognitif & Afektif' : 'Somatik'"></span>
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 mt-2">Detail Instrumen BDI-II</h3>
                                </div>
                                <button @click="showDetail = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <!-- Konten Modal -->
                            <div class="flex-1 p-6 space-y-6">
                                <!-- Warning Item Keselamatan -->
                                <template x-if="selectedQuestion.is_safety_item">
                                    <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start">
                                        <div class="bg-rose-100 p-2 rounded-xl mr-3 text-rose-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-rose-800 uppercase tracking-wider">Item Keselamatan Kritis</h4>
                                            <p class="text-[11px] text-rose-700 mt-1 leading-relaxed">Pertanyaan ini mengukur ideasi bunuh diri (BDI-9). Jika responden memilih skor >= 2, sistem akan langsung memicu protokol tanggap darurat.</p>
                                        </div>
                                    </div>
                                </template>

                                <!-- Teks Pertanyaan Utama -->
                                <div>
                                    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Teks Pertanyaan</h4>
                                    <p class="text-base font-bold text-slate-800 leading-relaxed" x-text="selectedQuestion.question_text"></p>
                                </div>

                                <!-- Opsi Jawaban & Skor -->
                                <div>
                                    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Opsi Jawaban & Bobot Nilai</h4>
                                    <div class="space-y-3">
                                        <template x-for="(option, index) in selectedQuestion.answer_options" :key="index">
                                            <div class="p-3.5 border border-slate-100 rounded-xl bg-slate-50/50 flex items-start gap-4">
                                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white border border-slate-200 text-xs font-bold text-[#0d7a70] flex items-center justify-center shadow-sm" x-text="index"></div>
                                                <p class="text-xs font-medium text-slate-600 leading-relaxed" x-text="option"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Modal -->
                            <div class="p-6 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between gap-3">
                                <div>
                                    <template x-if="!selectedQuestion.is_locked">
                                        <div class="flex items-center gap-2">
                                            <a :href="'{{ url('admin/questions') }}/' + selectedQuestion.id + '/edit'" class="px-4 py-2 bg-white border border-slate-200 text-[#0d7a70] text-xs font-bold rounded-xl hover:bg-slate-50 transition-all">Edit</a>
                                            <form :action="'{{ url('admin/questions') }}/' + selectedQuestion.id" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-rose-50 border border-rose-200 text-rose-600 text-xs font-bold rounded-xl hover:bg-rose-600 hover:text-white transition-all">Hapus</button>
                                            </form>
                                        </div>
                                    </template>
                                    <template x-if="selectedQuestion.is_locked">
                                        <span class="text-[10px] font-semibold text-slate-400">Version 1.0 (Locked)</span>
                                    </template>
                                </div>
                                <button @click="showDetail = false" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition-all">Tutup</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>