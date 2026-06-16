<x-admin-layout>

    <x-slot name="title">Manajemen Aturan (Sistem Pakar) | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

    <div x-data="{
        showDetail: false,
        selectedRule: null,
        openDetail(rule) {
            this.selectedRule = rule;
            this.showDetail = true;
        }
    }" class="relative">

    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Manajemen Aturan (Sistem Pakar)</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola logika inferensi fuzzy "JIKA... MAKA..." untuk diagnosis tingkat depresi secara dinamis.</p>
            </div>
            
            <div class="flex flex-col items-end gap-3">
                <a href="{{ route('admin.fuzzy-rules.create') }}" class="inline-flex items-center px-4 py-2 bg-[#0d7a70] text-white text-sm font-semibold rounded-xl hover:bg-[#0a635b] transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Aturan
                </a>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold text-slate-400">Terakhir Diperbarui:</span>
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl border border-slate-200">
                        {{ \App\Models\FuzzyRule::max('updated_at') ? \Carbon\Carbon::parse(\App\Models\FuzzyRule::max('updated_at'))->diffForHumans() : 'Belum diperbarui' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Box Notifikasi Sukses --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-emerald-100 text-emerald-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-emerald-800">Operasi Berhasil</h4>
                <p class="text-[11px] text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition-colors focus:outline-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif

    {{-- Metrics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="p-4 bg-[#ecf5f4] rounded-2xl text-[#0d7a70]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 block mb-0.5 uppercase tracking-wider">Total Aturan Basis</span>
                <span class="text-2xl font-black text-slate-800">{{ $totalRules }}</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="p-4 bg-emerald-50 rounded-2xl text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 block mb-0.5 uppercase tracking-wider">Aturan Aktif</span>
                <span class="text-2xl font-black text-emerald-600">{{ $totalRules - $inactiveRules }}</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="p-4 bg-rose-50 rounded-2xl text-rose-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 block mb-0.5 uppercase tracking-wider">Aturan Non-aktif</span>
                <span class="text-2xl font-black text-rose-500">{{ $inactiveRules }}</span>
            </div>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider bg-slate-50/50">
                        <th class="py-4 px-6 w-20">ID</th>
                        <th class="py-4 px-6">Deskripsi Kualitatif (JIKA)</th>
                        <th class="py-4 px-6">Keputusan Diagnostik (MAKA)</th>
                        <th class="py-4 px-6 w-24">Status</th>
                        <th class="py-4 px-6 w-28 text-center">Toggle Keaktifan</th>
                        <th class="py-4 px-6 w-28 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($rules as $rule)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-5 px-6 font-black text-slate-800">
                                R{{ sprintf('%03d', $rule->rule_number) }}
                            </td>
                            
                            <td class="py-5 px-6">
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium text-slate-600">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Kognitif-Afektif:</span>
                                        <span class="font-bold {{ $rule->antecedent_cognitive?->value === 'berat' ? 'text-rose-500' : ($rule->antecedent_cognitive?->value === 'sedang' ? 'text-amber-500' : ($rule->antecedent_cognitive?->value === 'ringan' ? 'text-indigo-500' : ($rule->antecedent_cognitive?->value === 'minimal' ? 'text-emerald-500' : 'text-slate-500'))) }}">
                                            {{ $rule->antecedent_cognitive ? ucfirst($rule->antecedent_cognitive->value) : 'Any' }}
                                        </span>
                                    </div>
                                    <span class="text-[9px] font-black text-slate-300">AND</span>

                                    <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium text-slate-600">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Somatik:</span>
                                        <span class="font-bold {{ $rule->antecedent_somatic?->value === 'berat' ? 'text-rose-500' : ($rule->antecedent_somatic?->value === 'sedang' ? 'text-amber-500' : ($rule->antecedent_somatic?->value === 'ringan' ? 'text-indigo-500' : ($rule->antecedent_somatic?->value === 'minimal' ? 'text-emerald-500' : 'text-slate-500'))) }}">
                                            {{ $rule->antecedent_somatic ? ucfirst($rule->antecedent_somatic->value) : 'Any' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="py-5 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold border uppercase tracking-wider
                                    {{ $rule->consequent->value === 'berat' ? 'bg-rose-50 text-rose-600 border-rose-100' : 
                                       ($rule->consequent->value === 'sedang' ? 'bg-amber-50 text-amber-600 border-amber-100' : 
                                       ($rule->consequent->value === 'ringan' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 
                                                                               'bg-emerald-50 text-emerald-600 border-emerald-100')) }}">
                                    {{ $rule->consequent->value }}
                                </span>
                            </td>

                            <td class="py-5 px-6">
                                @if($rule->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-slate-100 text-slate-400 border border-slate-200">Non-aktif</span>
                                @endif
                            </td>

                            <td class="py-5 px-6 text-center">
                                <form action="{{ route('admin.fuzzy-rules.update', $rule->id) }}" method="POST" class="inline-block align-middle">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_action" value="toggle">
                                    <input type="hidden" name="is_active" value="{{ $rule->is_active ? 0 : 1 }}">
                                    <button type="submit" 
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $rule->is_active ? 'bg-[#0d7a70]' : 'bg-slate-200' }}"
                                            title="{{ $rule->is_active ? 'Klik untuk menonaktifkan aturan ini' : 'Klik untuk mengaktifkan aturan ini' }}">
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $rule->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </form>
                            </td>

                            <td class="py-5 px-6 text-center">
                                <button @click="openDetail({{ json_encode(['id_real' => $rule->id, 'id' => $rule->rule_number, 'is_active' => $rule->is_active, 'updated_at' => $rule->updated_at->format('d M Y'), 'antecedent_total' => $rule->antecedent_total?->value, 'antecedent_cognitive' => $rule->antecedent_cognitive?->value, 'antecedent_somatic' => $rule->antecedent_somatic?->value, 'consequent' => $rule->consequent->value, 'description' => $rule->description]) }})"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-100 transition-all">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-slate-400 italic">
                                Belum ada aturan fuzzy yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div x-show="showDetail"
         class="fixed inset-0 overflow-hidden z-50"
         style="display:none;"
         x-transition>
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showDetail = false"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div x-show="showDetail"
                 x-transition:enter="transform transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transform transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg p-8 relative">

                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-black text-slate-800">Detail Aturan</h3>
                        <p class="text-sm text-slate-400 mt-0.5" x-text="selectedRule ? 'R' + String(selectedRule.id).padStart(3, '0') : ''"></p>
                    </div>
                    <button @click="showDetail = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <template x-if="selectedRule">
                    <div class="space-y-5">
                        {{-- Info Umum --}}
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Informasi Umum</p>
                            <div class="grid grid-cols-3 gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">ID Aturan</p>
                                    <p class="text-sm font-black text-slate-800" x-text="'R' + String(selectedRule.id).padStart(3, '0')"></p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status</p>
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-black uppercase border"
                                          :class="selectedRule.is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-500 border-slate-200'"
                                          x-text="selectedRule.is_active ? 'Aktif' : 'Non-Aktif'"></span>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Update Terakhir</p>
                                    <p class="text-xs font-semibold text-slate-700" x-text="selectedRule.updated_at"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Kondisi JIKA --}}
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Kondisi (JIKA)</p>
                            <div class="bg-slate-50 rounded-2xl border border-slate-100 p-4 space-y-2">
                                <div class="p-3 bg-white border border-slate-200 rounded-xl flex justify-between items-center">
                                    <span class="text-xs font-bold text-slate-500">Kognitif & Afektif</span>
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-black uppercase border"
                                          :class="{
                                              'bg-rose-50 text-rose-700 border-rose-200': selectedRule.antecedent_cognitive === 'berat',
                                              'bg-amber-50 text-amber-700 border-amber-200': selectedRule.antecedent_cognitive === 'sedang',
                                              'bg-indigo-50 text-indigo-600 border-indigo-200': selectedRule.antecedent_cognitive === 'ringan',
                                              'bg-emerald-50 text-emerald-700 border-emerald-200': selectedRule.antecedent_cognitive === 'minimal',
                                              'bg-slate-100 text-slate-500 border-slate-200': !selectedRule.antecedent_cognitive
                                          }"
                                          x-text="selectedRule.antecedent_cognitive ? selectedRule.antecedent_cognitive.charAt(0).toUpperCase() + selectedRule.antecedent_cognitive.slice(1) : 'ANY'"></span>
                                </div>
                                <div class="text-center text-[9px] font-black text-slate-400 uppercase tracking-widest">DAN</div>
                                <div class="p-3 bg-white border border-slate-200 rounded-xl flex justify-between items-center">
                                    <span class="text-xs font-bold text-slate-500">Somatik (Fisik)</span>
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-black uppercase border"
                                          :class="{
                                              'bg-rose-50 text-rose-700 border-rose-200': selectedRule.antecedent_somatic === 'berat',
                                              'bg-amber-50 text-amber-700 border-amber-200': selectedRule.antecedent_somatic === 'sedang',
                                              'bg-indigo-50 text-indigo-600 border-indigo-200': selectedRule.antecedent_somatic === 'ringan',
                                              'bg-emerald-50 text-emerald-700 border-emerald-200': selectedRule.antecedent_somatic === 'minimal',
                                              'bg-slate-100 text-slate-500 border-slate-200': !selectedRule.antecedent_somatic
                                          }"
                                          x-text="selectedRule.antecedent_somatic ? selectedRule.antecedent_somatic.charAt(0).toUpperCase() + selectedRule.antecedent_somatic.slice(1) : 'ANY'"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Kesimpulan MAKA --}}
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Kesimpulan (MAKA)</p>
                            <div class="p-4 rounded-2xl border flex items-center justify-between"
                                 :class="{
                                     'bg-rose-50 border-rose-200': selectedRule.consequent === 'berat',
                                     'bg-amber-50 border-amber-200': selectedRule.consequent === 'sedang',
                                     'bg-indigo-50 border-indigo-200': selectedRule.consequent === 'ringan',
                                     'bg-emerald-50 border-emerald-200': selectedRule.consequent === 'minimal',
                                 }">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-xl"
                                         :class="{
                                             'bg-rose-100 text-rose-600': selectedRule.consequent === 'berat',
                                             'bg-amber-100 text-amber-600': selectedRule.consequent === 'sedang',
                                             'bg-indigo-100 text-indigo-600': selectedRule.consequent === 'ringan',
                                             'bg-emerald-100 text-emerald-600': selectedRule.consequent === 'minimal',
                                         }">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <span class="font-black text-base"
                                          :class="{
                                              'text-rose-700': selectedRule.consequent === 'berat',
                                              'text-amber-700': selectedRule.consequent === 'sedang',
                                              'text-indigo-700': selectedRule.consequent === 'ringan',
                                              'text-emerald-700': selectedRule.consequent === 'minimal',
                                          }"
                                          x-text="'Depresi ' + selectedRule.consequent.charAt(0).toUpperCase() + selectedRule.consequent.slice(1)"></span>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg border bg-white/60"
                                      :class="{
                                          'text-rose-600 border-rose-200': selectedRule.consequent === 'berat',
                                          'text-amber-600 border-amber-200': selectedRule.consequent === 'sedang',
                                          'text-indigo-600 border-indigo-200': selectedRule.consequent === 'ringan',
                                          'text-emerald-600 border-emerald-200': selectedRule.consequent === 'minimal',
                                      }">Diagnosis</span>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <template x-if="selectedRule.description">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan Administratif</p>
                                <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <p class="text-xs text-slate-600 leading-relaxed italic" x-text="selectedRule.description"></p>
                                </div>
                            </div>
                        </template>

                        <div class="pt-2 flex items-center gap-3">
                            <a :href="'{{ url('admin/fuzzy-rules') }}/' + selectedRule.id_real + '/edit'" class="w-full text-center py-3 bg-white border border-slate-200 text-[#0d7a70] font-bold text-sm rounded-xl hover:bg-slate-50 transition-colors">Edit</a>
                            <form :action="'{{ url('admin/fuzzy-rules') }}/' + selectedRule.id_real" method="POST" onsubmit="return confirm('Hapus aturan ini?')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-3 bg-rose-50 border border-rose-200 text-rose-600 font-bold text-sm rounded-xl hover:bg-rose-600 hover:text-white transition-colors">Hapus</button>
                            </form>
                            <button @click="showDetail = false"
                                    class="w-full py-3 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors">
                                Tutup
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    </div>
</x-admin-layout>