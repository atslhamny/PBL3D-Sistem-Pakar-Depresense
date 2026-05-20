<x-guest-layout maxWidth="max-w-5xl">
    <div x-data="screeningForm({{ $question->id }}, {{ $question->item_number }}, {{ Js::from($question->answer_options) }})" class="w-full">
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
                <span class="block text-sm text-[#0d7a70] mb-2 uppercase tracking-tighter">Item {{ $question->item_number }}</span>
                {{ $question->question_text }}
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
        document.addEventListener('alpine:init', () => {
            Alpine.data('screeningForm', (questionId, itemNumber, answerOptions) => ({
                questionId: questionId,
                itemNumber: itemNumber,
                selected: null,
                isSubmitting: false,
                error: null,

                options: answerOptions.map((text, i) => ({ text: text, value: i })),

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