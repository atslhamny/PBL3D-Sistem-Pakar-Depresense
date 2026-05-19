<x-guest-layout maxWidth="max-w-5xl">
    <div x-data="screeningForm({{ $question->id }}, {{ $question->item_number }})" class="w-full">
        {{-- Progress Bar --}}
        <div class="mb-10">
            <div class="flex justify-between items-end text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">
                <span>Pertanyaan {{ $question->item_number }} <span class="text-slate-300">/</span> 21</span>
                <span class="text-[#00aba9]">{{ round($progress) }}%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden border border-slate-50">
                <div class="bg-[#00aba9] h-3 rounded-full transition-all duration-700 ease-out shadow-sm shadow-teal-100" 
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        {{-- Pertanyaan Dinamis --}}
        <div class="mb-10 text-center">
            <h3 class="text-xl md:text-2xl font-bold text-slate-800 leading-tight px-2">
                {{-- Judul Item (Contoh: Item 1 — Kesedihan) --}}
                <span class="block text-sm text-[#0d7a70] mb-2 uppercase tracking-tighter">Item {{ $question->item_number }}</span>
                {{-- Teks Pertanyaan Lengkap dari Dokumen --}}
                <span x-text="questionText"></span>
            </h3>
            <div class="inline-block mt-4 px-4 py-1.5 bg-slate-50 border border-slate-100 rounded-full">
                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">
                    Kategori: <span class="text-[#0d7a70]">{{ $question->item_number <= 13 ? 'Kognitif-Afektif' : 'Somatik' }}</span>
                </p>
            </div>
        </div>

        <form @submit.prevent="submitAnswer" class="space-y-4">
            <template x-for="(option, index) in options" :key="index">
                <label
                    class="flex items-start gap-4 rounded-2xl border-2 p-5 cursor-pointer transition-all duration-200"
                    :class="selected === index
                        ? 'border-[#00aba9] bg-[#f0fdfa] shadow-sm shadow-teal-50'
                        : 'border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50'"
                >
                    <input
                        type="radio"
                        name="answer_value"
                        :value="index"
                        x-model="selected"
                        class="mt-1 w-5 h-5 accent-[#00aba9] cursor-pointer flex-shrink-0"
                    >

                    <div class="flex flex-col">
                        <span
                            class="text-base leading-snug font-semibold transition-colors duration-200"
                            :class="selected === index ? 'text-[#0d7a70]' : 'text-slate-700'"
                            x-text="option.text"
                        ></span>
                    </div>
                </label>
            </template>

            {{-- Error Alert --}}
            <div x-show="error" x-transition class="mt-6 p-4 text-xs font-medium text-red-600 bg-red-50 rounded-2xl border border-red-100 flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-text="error"></span>
            </div>

            <div class="mt-10 pt-4">
                <button type="submit" 
                        :disabled="selected === null || isSubmitting"
                        class="w-full flex justify-center items-center px-6 py-4 border border-transparent rounded-2xl shadow-md shadow-teal-100 text-lg font-bold text-white bg-[#00aba9] hover:bg-[#0d7a70] focus:outline-none focus:ring-4 focus:ring-teal-100 disabled:opacity-40 disabled:cursor-not-allowed transition-all active:scale-[0.98]">
                    
                    <span x-show="!isSubmitting" class="flex items-center gap-2">
                        Lanjut
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </span>
                    
                    <span x-show="isSubmitting" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <script>
        // Data Pertanyaan & Jawaban Lengkap dari BDI21_Pertanyaan_Jawaban_Deskriptif.docx
        const bdiData = {
            1: {
                q: "Bagaimana perasaan umum yang kamu rasakan dalam dua minggu terakhir ini?",
                a: ["Saya merasa biasa saja. Tidak ada rasa sedih yang mengganggu.", 
                    "Saya kadang-kadang merasa sedih atau murung.", 
                    "Saya hampir setiap saat merasa sedih tanpa tahu alasan yang jelas.", 
                    "Saya terus-menerus merasa sangat sedih hingga terasa menyiksa."]
            },
            2: {
                q: "Bagaimana pandanganmu tentang masa depan dalam dua minggu terakhir ini?",
                a: ["Saya masih bisa melihat kemungkinan-kemungkinan baik di masa depan.", 
                    "Saya merasa kurang yakin dengan masa depan saya dibanding biasanya.", 
                    "Saya sulit membayangkan ada hal baik yang akan terjadi.", 
                    "Saya yakin masa depan saya akan buruk."]
            },
            3: {
                q: "Bagaimana kamu menilai pengalaman hidupmu selama ini, terutama tentang keberhasilan dan kegagalan?",
                a: ["Saya tidak merasa bahwa saya lebih banyak gagal dari orang lain.", 
                    "Saya merasa sudah lebih banyak mengalami kegagalan dibanding orang lain.", 
                    "Ketika saya merenungkan hidup saya, yang dominan adalah kegagalan.", 
                    "Saya merasa hidup saya adalah rangkaian kegagalan total."]
            },
            4: {
                q: "Apakah kamu masih bisa menikmati hal-hal yang sebelumnya kamu sukai atau anggap menyenangkan?",
                a: ["Saya masih bisa menikmati hal-hal yang saya sukai seperti biasanya.", 
                    "Saya merasa kurang bisa menikmati hal-hal yang biasanya saya suka.", 
                    "Hampir semua hal yang dulu saya nikmati kini terasa hambar.", 
                    "Tidak ada satupun hal yang bisa membuat saya merasa senang."]
            },
            5: {
                q: "Seberapa sering kamu merasa bersalah atas hal-hal yang telah kamu lakukan atau tidak kamu lakukan?",
                a: ["Saya tidak merasa bersalah lebih dari yang wajar.", 
                    "Saya lebih sering merasa bersalah dari biasanya atas hal-hal kecil.", 
                    "Saya hampir selalu merasa bersalah.", 
                    "Saya merasa bersalah terus-menerus atas hampir semua hal."]
            },
            6: {
                q: "Apakah kamu merasa bahwa hal-hal buruk yang terjadi kepadamu adalah sebuah bentuk hukuman?",
                a: ["Saya tidak merasa sedang dihukum atas apapun.", 
                    "Terkadang saya berpikir mungkin kejadian buruk ini adalah semacam ganjaran.", 
                    "Saya merasa bahwa saya memang layak mendapat hukuman.", 
                    "Saya yakin saya sedang dihukum."]
            },
            7: {
                q: "Bagaimana perasaanmu terhadap dirimu sendiri belakangan ini?",
                a: ["Saya merasa baik-baik saja dengan diri saya.", 
                    "Saya merasa kurang puas dengan diri saya belakangan ini.", 
                    "Saya tidak menyukai diri saya sendiri.", 
                    "Saya membenci diri saya sendiri."]
            },
            8: {
                q: "Apakah kamu cenderung menyalahkan dirimu sendiri ketika ada hal yang tidak berjalan dengan baik?",
                a: ["Saya tidak lebih menyalahkan diri sendiri dari biasanya.", 
                    "Saya lebih sering mengkritik diri sendiri dari biasanya.", 
                    "Saya hampir selalu menyalahkan diri sendiri atas berbagai masalah.", 
                    "Saya merasa bertanggung jawab atas semua hal buruk yang terjadi."]
            },
            9: {
                q: "Apakah kamu pernah memiliki pikiran untuk menyakiti diri sendiri atau tidak ingin hidup lagi?",
                a: ["Saya tidak memiliki pikiran untuk menyakiti diri sendiri.", 
                    "Saya pernah berharap bisa tidur dan tidak bangun lagi.", 
                    "Pikiran untuk mengakhiri hidup cukup sering muncul.", 
                    "Saya memiliki pikiran kuat untuk bunuh diri."]
            },
            10: {
                q: "Seberapa sering kamu menangis dalam dua minggu terakhir ini?",
                a: ["Saya tidak lebih sering menangis dari biasanya.", 
                    "Saya lebih mudah menangis belakangan ini.", 
                    "Saya hampir selalu menangis untuk berbagai hal.", 
                    "Saya tidak bisa berhenti menangis meskipun sudah berusaha."]
            },
            11: {
                q: "Apakah kamu merasa lebih gelisah atau tidak bisa tenang belakangan ini?",
                a: ["Saya tidak merasa lebih gelisah dari biasanya.", 
                    "Saya merasa lebih gelisah dan resah dari biasanya.", 
                    "Saya merasa sangat gelisah dan tegang.", 
                    "Saya tidak bisa duduk atau berdiam diri sama sekali."]
            },
            12: {
                q: "Apakah kamu masih tertarik untuk melakukan berbagai aktivitas atau berinteraksi dengan orang lain?",
                a: ["Saya masih tertarik pada berbagai aktivitas seperti biasanya.", 
                    "Saya merasa kurang bersemangat dan kurang tertarik pada banyak hal.", 
                    "Saya telah kehilangan sebagian besar minat saya.", 
                    "Saya sama sekali tidak tertarik pada apapun atau siapapun."]
            },
            13: {
                q: "Seberapa mudah kamu membuat keputusan dalam dua minggu terakhir?",
                a: ["Saya masih bisa mengambil keputusan seperti biasanya.", 
                    "Saya merasa lebih sulit mengambil keputusan dari biasanya.", 
                    "Mengambil keputusan terasa sangat berat.", 
                    "Saya hampir tidak bisa membuat keputusan apapun."]
            },
            14: {
                q: "Apakah kamu merasa dirimu berharga atau memiliki nilai sebagai seorang manusia?",
                a: ["Saya tidak merasa diri saya tidak berharga.", 
                    "Saya merasa kurang berharga dari sebelumnya.", 
                    "Saya merasa diri saya tidak berharga.", 
                    "Saya benar-benar merasa tidak berharga dan tidak berguna."]
            },
            15: {
                q: "Bagaimana tingkat energimu untuk menjalani aktivitas sehari-hari dalam dua minggu terakhir?",
                a: ["Energi saya masih cukup untuk menjalani hari.", 
                    "Saya merasa lebih mudah lelah dari biasanya.", 
                    "Energi saya terasa sangat terbatas.", 
                    "Saya hampir tidak memiliki energi sama sekali."]
            },
            16: {
                q: "Apakah ada perubahan pada pola tidurmu dalam dua minggu terakhir ini?",
                a: ["Pola tidur saya masih normal seperti biasanya.", 
                    "Pola tidur saya sedikit berubah (tidur lebih lama/sebentar).", 
                    "Tidur saya cukup terganggu (sering insomnia/berlebihan).", 
                    "Pola tidur saya sangat kacau."]
            },
            17: {
                q: "Apakah kamu lebih mudah merasa kesal, marah, atau terganggu?",
                a: ["Saya tidak lebih mudah marah dari biasanya.", 
                    "Saya lebih gampang kesal dari biasanya.", 
                    "Saya merasa sangat mudah marah hampir setiap hari.", 
                    "Saya terus-menerus merasa marah dan mudah tersulut."]
            },
            18: {
                q: "Apakah ada perubahan pada nafsu makan atau kebiasaan makanmu?",
                a: ["Nafsu makan saya masih normal.", 
                    "Nafsu makan saya sedikit berkurang atau bertambah.", 
                    "Nafsu makan saya berubah cukup signifikan.", 
                    "Saya hampir tidak nafsu makan atau makan berlebihan tanpa kontrol."]
            },
            19: {
                q: "Seberapa mudah kamu berkonsentrasi atau memusatkan perhatian?",
                a: ["Konsentrasi saya masih baik seperti biasanya.", 
                    "Saya merasa sulit untuk berkonsentrasi lebih dari beberapa menit.", 
                    "Sangat sulit bagi saya untuk fokus pada apapun.", 
                    "Saya tidak bisa berkonsentrasi sama sekali."]
            },
            20: {
                q: "Seberapa lelah yang kamu rasakan dalam menjalani aktivitas sehari-hari?",
                a: ["Saya tidak merasa lebih lelah dari biasanya.", 
                    "Saya merasa lebih cepat lelah dari biasanya.", 
                    "Kelelahan saya cukup parah hingga harus membatalkan kegiatan.", 
                    "Saya kelelahan luar biasa yang hampir melumpuhkan."]
            },
            21: {
                q: "Apakah ada perubahan pada minat atau dorongan seksualmu?",
                a: ["Tidak ada perubahan berarti pada minat seksual saya.", 
                    "Minat seksual saya terasa sedikit berkurang.", 
                    "Minat seksual saya berkurang cukup jauh.", 
                    "Saya kehilangan minat seksual sepenuhnya."]
            }
        };

        document.addEventListener('alpine:init', () => {
            Alpine.data('screeningForm', (questionId, itemNumber) => ({
                questionId: questionId,
                itemNumber: itemNumber,
                selected: null,
                isSubmitting: false,
                error: null,
                
                // Mengambil data berdasarkan item_number
                questionText: bdiData[itemNumber]?.q || "Pertanyaan tidak ditemukan.",
                options: (bdiData[itemNumber]?.a || []).map((text, i) => ({ text: text, value: i })),

                async submitAnswer() {
                    if (this.selected === null) return;
                    this.isSubmitting = true;
                    this.error = null;

                    try {
                        const response = await fetch('{{ route("screening.answer") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                question_id: this.questionId,
                                item_number: this.itemNumber,
                                answer_value: this.selected
                            })
                        });

                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Gagal menyimpan jawaban.');

                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.reload();
                        }
                    } catch (e) {
                        this.error = e.message;
                        this.isSubmitting = false;
                    }
                }
            }));
        });
    </script>
</x-guest-layout>