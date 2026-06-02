<x-admin-layout title="Tambah Aturan Fuzzy">
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.fuzzy-rules.index') }}" class="p-2 text-slate-400 hover:text-[#0d7a70] hover:bg-slate-100 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tambah Aturan Fuzzy</h2>
                <p class="text-slate-500 text-sm mt-1">Buat logika inferensi baru untuk sistem pakar.</p>
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
        <form action="{{ route('admin.fuzzy-rules.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Aturan (Rule Number) <span class="text-rose-500">*</span></label>
                        <input type="number" name="rule_number" value="{{ old('rule_number') }}" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm">
                    </div>

                    <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 space-y-4">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-2">IF (Anteseden)</h3>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Total Skor Keseluruhan</label>
                            <select name="antecedent_total"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm">
                                <option value="">(Abaikan / None)</option>
                                <option value="minimal" {{ old('antecedent_total') === 'minimal' ? 'selected' : '' }}>Minimal</option>
                                <option value="ringan" {{ old('antecedent_total') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="sedang" {{ old('antecedent_total') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="berat" {{ old('antecedent_total') === 'berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Skor Kognitif & Afektif</label>
                            <select name="antecedent_cognitive"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm">
                                <option value="">(Abaikan / None)</option>
                                <option value="minimal" {{ old('antecedent_cognitive') === 'minimal' ? 'selected' : '' }}>Minimal</option>
                                <option value="ringan" {{ old('antecedent_cognitive') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="sedang" {{ old('antecedent_cognitive') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="berat" {{ old('antecedent_cognitive') === 'berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Skor Somatik</label>
                            <select name="antecedent_somatic"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm">
                                <option value="">(Abaikan / None)</option>
                                <option value="minimal" {{ old('antecedent_somatic') === 'minimal' ? 'selected' : '' }}>Minimal</option>
                                <option value="ringan" {{ old('antecedent_somatic') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="sedang" {{ old('antecedent_somatic') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="berat" {{ old('antecedent_somatic') === 'berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="p-5 bg-emerald-50 rounded-xl border border-emerald-100">
                        <h3 class="text-sm font-black text-[#0d7a70] uppercase tracking-wider mb-4">THEN (Konsekuen)</h3>
                        <div>
                            <label class="block text-xs font-bold text-[#0d7a70] mb-1">Tingkat Depresi Kesimpulan <span class="text-rose-500">*</span></label>
                            <select name="consequent" required
                                    class="w-full px-4 py-3 bg-white border border-emerald-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-2 focus:ring-[#0d7a70]/20 transition-all text-sm font-bold text-[#0d7a70]">
                                <option value="">Pilih Hasil...</option>
                                <option value="minimal" {{ old('consequent') === 'minimal' ? 'selected' : '' }}>Minimal</option>
                                <option value="ringan" {{ old('consequent') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="sedang" {{ old('consequent') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="berat" {{ old('consequent') === 'berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-5 border border-slate-100 rounded-xl">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-[#0d7a70] rounded border-slate-300 focus:ring-[#0d7a70]">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Status Aktif</span>
                                <span class="block text-xs text-slate-500 mt-0.5">Terapkan aturan ini dalam proses inferensi fuzzy.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.fuzzy-rules.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-[#0d7a70] hover:bg-[#0a635b] rounded-xl transition-colors shadow-sm">Simpan Aturan</button>
            </div>
        </form>
    </div>
</x-admin-layout>
