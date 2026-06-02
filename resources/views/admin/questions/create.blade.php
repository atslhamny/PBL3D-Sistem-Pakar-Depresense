<x-admin-layout title="Tambah Pertanyaan BDI-II">
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.questions.index') }}" class="p-2 text-slate-400 hover:text-[#0d7a70] hover:bg-slate-100 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tambah Pertanyaan</h2>
                <p class="text-slate-500 text-sm mt-1">Buat butir pertanyaan baru untuk kuesioner BDI-II.</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-3">
        <div class="p-2 bg-rose-100 text-rose-600 rounded-xl flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h3 class="text-sm font-bold text-rose-800 mb-1">Terjadi Kesalahan</h3>
            <ul class="text-xs text-rose-700 list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <form action="{{ route('admin.questions.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Kolom Kiri -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Item <span class="text-rose-500">*</span></label>
                        <input type="number" name="item_number" value="{{ old('item_number') }}" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Urutan Tampil (Sort Order) <span class="text-rose-500">*</span></label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Utama <span class="text-rose-500">*</span></label>
                        <select name="category" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm">
                            <option value="">Pilih Kategori...</option>
                            <option value="kognitif_afektif" {{ old('category') === 'kognitif_afektif' ? 'selected' : '' }}>Kognitif Afektif</option>
                            <option value="somatik" {{ old('category') === 'somatik' ? 'selected' : '' }}>Somatik</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Sub Kategori <span class="text-rose-500">*</span></label>
                        <select name="sub_category" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm">
                            <option value="">Pilih Sub Kategori...</option>
                            <option value="emosi" {{ old('sub_category') === 'emosi' ? 'selected' : '' }}>Emosi</option>
                            <option value="kognitif" {{ old('sub_category') === 'kognitif' ? 'selected' : '' }}>Kognitif</option>
                            <option value="fisik" {{ old('sub_category') === 'fisik' ? 'selected' : '' }}>Fisik</option>
                        </select>
                    </div>

                    <div class="p-5 bg-rose-50 rounded-xl border border-rose-100">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_safety_item" value="1" {{ old('is_safety_item') ? 'checked' : '' }}
                                   class="w-5 h-5 text-rose-600 rounded border-rose-300 focus:ring-rose-500">
                            <div>
                                <span class="block text-sm font-bold text-rose-900">Safety Item (Darurat)</span>
                                <span class="block text-xs text-rose-700 mt-0.5">Centang jika pertanyaan ini berkaitan dengan risiko bunuh diri.</span>
                            </div>
                        </label>
                        <div class="mt-4">
                            <label class="block text-xs font-bold text-rose-800 mb-1">Ambang Batas Darurat (Safety Threshold)</label>
                            <input type="number" name="safety_threshold" value="{{ old('safety_threshold') }}" placeholder="Contoh: 2"
                                   class="w-full px-4 py-2.5 bg-white border border-rose-200 rounded-lg focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-400/20 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-6 flex flex-col">
                    <div class="flex-grow flex flex-col">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Teks Pertanyaan (Topik) <span class="text-rose-500">*</span></label>
                        <textarea name="question_text" required rows="2"
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm resize-none mb-6">{{ old('question_text') }}</textarea>

                        <div x-data="optionsHandler()" class="flex-grow flex flex-col">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-bold text-slate-700">Opsi Jawaban <span class="text-rose-500">*</span></label>
                                <button type="button" @click="addOption()" class="text-xs font-bold text-[#0d7a70] hover:text-[#0a635b] flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Tambah Opsi
                                </button>
                            </div>
                            
                            <div class="space-y-3">
                                <template x-for="(option, index) in options" :key="index">
                                    <div class="flex items-start gap-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
                                        <div class="w-20 flex-shrink-0">
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Skor</label>
                                            <input type="number" x-model="option.score" :name="'options['+index+'][score]'" required min="0"
                                                   class="w-full px-3 py-2 text-center bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#0d7a70] text-sm font-bold text-[#0d7a70]">
                                        </div>
                                        <div class="flex-grow">
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Pernyataan</label>
                                            <input type="text" x-model="option.text" :name="'options['+index+'][text]'" required
                                                   class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#0d7a70] text-sm">
                                        </div>
                                        <button type="button" @click="removeOption(index)" x-show="options.length > 2"
                                                class="mt-5 p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.questions.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-[#0d7a70] hover:bg-[#0a635b] rounded-xl transition-colors shadow-sm">Simpan Pertanyaan</button>
            </div>
        </form>
    </div>

    <script>
        function optionsHandler() {
            let initialOptions = [
                { score: 0, text: '' },
                { score: 1, text: '' },
                { score: 2, text: '' },
                { score: 3, text: '' }
            ];
            
            // Check if there are old options from validation error
            @if(old('options'))
                initialOptions = {!! json_encode(old('options')) !!};
            @endif

            return {
                options: initialOptions,
                addOption() {
                    this.options.push({ score: this.options.length, text: '' });
                },
                removeOption(index) {
                    if (this.options.length > 2) {
                        this.options.splice(index, 1);
                    }
                }
            }
        }
    </script>
</x-admin-layout>
