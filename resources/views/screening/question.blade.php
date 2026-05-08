<x-guest-layout>
    <div x-data="screeningForm({{ $question->id }}, {{ $question->item_number }})" class="w-full">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between text-xs font-medium text-slate-500 dark:text-slate-400 mb-2">
                <span>Pertanyaan {{ $question->item_number }} dari 21</span>
                <span>{{ round($progress) }}%</span>
            </div>
            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500 ease-out" style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <!-- Question -->
        <div class="mb-8 text-center">
            <h3 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white leading-tight">
                Bagaimana perasaan Anda terkait hal ini dalam dua minggu terakhir?
            </h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 uppercase tracking-wider font-semibold">
                Kategori: {{ str_replace('_', ' ', $question->category->value) }}
            </p>
        </div>

        <!-- Options (Alpine JS based) -->
        <form @submit.prevent="submitAnswer" class="space-y-4">
            <template x-for="(option, index) in options" :key="index">
                <label 
                    class="block relative rounded-2xl border-2 p-5 cursor-pointer transition-all duration-200"
                    :class="selected === index ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 dark:border-indigo-500' : 'border-slate-200 bg-white hover:border-indigo-300 dark:border-slate-700 dark:bg-slate-800 dark:hover:border-slate-500'"
                >
                    <input type="radio" name="answer_value" :value="index" x-model="selected" class="sr-only">
                    <div class="flex items-center">
                        <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-4"
                             :class="selected === index ? 'border-indigo-600 dark:border-indigo-400' : 'border-slate-300 dark:border-slate-600'">
                            <div class="w-3 h-3 rounded-full bg-indigo-600 dark:bg-indigo-400 transition-transform duration-200"
                                 :class="selected === index ? 'scale-100' : 'scale-0'"></div>
                        </div>
                        <span class="text-slate-700 dark:text-slate-200 font-medium text-lg" x-text="option.text"></span>
                    </div>
                </label>
            </template>

            <!-- Error message -->
            <div x-show="error" x-transition class="mt-4 p-4 text-sm text-red-600 bg-red-50 dark:bg-red-900/30 dark:text-red-400 rounded-xl">
                <span x-text="error"></span>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 pt-4">
                <button type="submit" 
                        :disabled="selected === null || isSubmitting"
                        class="w-full flex justify-center items-center px-6 py-4 border border-transparent rounded-xl shadow-sm text-lg font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                    <span x-show="!isSubmitting">Lanjut</span>
                    <span x-show="isSubmitting" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
        const bdiOptions = {
            1: ['Saya tidak merasa sedih.', 'Saya merasa sedih.', 'Saya sedih sepanjang waktu dan tidak bisa menghilangkannya.', 'Saya sangat sedih / tidak bahagia sehingga saya tidak tahan lagi.'],
            9: ['Saya tidak punya pikiran untuk bunuh diri.', 'Saya punya pikiran untuk bunuh diri, tapi tidak akan melakukannya.', 'Saya ingin bunuh diri.', 'Saya akan bunuh diri jika ada kesempatan.'],
            default: ['Sama sekali tidak', 'Kadang-kadang', 'Sering', 'Hampir setiap saat']
        };

        function getOptions(itemNumber) {
            let opts = bdiOptions[itemNumber] || bdiOptions.default;
            return opts.map((text, i) => ({ text: text, value: i }));
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('screeningForm', (questionId, itemNumber) => ({
                questionId: questionId,
                itemNumber: itemNumber,
                selected: null,
                isSubmitting: false,
                error: null,
                options: getOptions(itemNumber),

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

                        if (!response.ok) {
                            throw new Error(data.message || 'Terjadi kesalahan saat menyimpan jawaban.');
                        }

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
