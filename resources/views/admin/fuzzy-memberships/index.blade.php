<x-admin-layout>

    <x-slot name="title">Fungsi Keanggotaan Fuzzy | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

    <div x-data="{ editModal: false, editItem: null, showSuccess: {{ session('success') ? 'true' : 'false' }} }" class="relative">

        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Fungsi Keanggotaan Fuzzy</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola parameter fungsi keanggotaan (a, b, c, d) untuk setiap variabel linguistik sistem inferensi Mamdani.</p>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-xl font-bold border border-slate-200">{{ $totalVariables }} Variabel</span>
                <span class="px-3 py-1.5 bg-[#ecf5f4] text-[#0d7a70] rounded-xl font-bold border border-teal-100">{{ $totalParams }} Parameter</span>
            </div>
        </div>

        {{-- Success Alert --}}
        <div x-show="showSuccess" x-transition @click.away="showSuccess = false"
             class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-100 text-emerald-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-xs font-bold text-emerald-800">{{ session('success') ?? 'Berhasil diperbarui.' }}</p>
            </div>
            <button @click="showSuccess = false" class="text-emerald-400 hover:text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Info Card --}}
        <div class="mb-8 p-5 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-4">
            <div class="p-2.5 bg-blue-100 text-blue-600 rounded-xl flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-blue-800 uppercase tracking-wider">Panduan Parameter Fungsi Keanggotaan</p>
                <p class="text-[11px] text-blue-700 mt-1 leading-relaxed">
                    Setiap fungsi keanggotaan didefinisikan oleh 4 parameter: <strong>a</strong> (titik awal), <strong>b</strong> (awal plateau), <strong>c</strong> (akhir plateau), <strong>d</strong> (titik akhir).
                    Perubahan parameter ini akan langsung memengaruhi hasil diagnosis. Lakukan dengan hati-hati.
                </p>
            </div>
        </div>

        {{-- Grouped by Variable --}}
        <div class="space-y-6">
            @foreach($grouped as $variableName => $params)
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                {{-- Variable Header --}}
                <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-[#ecf5f4] rounded-xl text-[#0d7a70]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-800">{{ ucwords(str_replace('_', ' ', $variableName)) }}</h3>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $params->count() }} fungsi keanggotaan</p>
                        </div>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider bg-slate-100 px-3 py-1 rounded-full">Variabel Input</span>
                </div>

                {{-- Params Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                <th class="py-3 px-6">Label Linguistik</th>
                                <th class="py-3 px-6">Tipe Fungsi</th>
                                <th class="py-3 px-6 text-center">Param A</th>
                                <th class="py-3 px-6 text-center">Param B</th>
                                <th class="py-3 px-6 text-center">Param C</th>
                                <th class="py-3 px-6 text-center">Param D</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($params as $param)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <td class="py-4 px-6">
                                    @php
                                        $lv = $param->linguistic_label->value;
                                        $lc = match($lv) {
                                            'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'ringan' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                            default => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-black uppercase border {{ $lc }}">{{ ucfirst($lv) }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-xs font-semibold text-slate-600 font-mono">{{ str_replace('_', ' ', $param->function_type->value) }}</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="text-sm font-black text-slate-800 font-mono">{{ number_format($param->param_a, 2) }}</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="text-sm font-black text-slate-800 font-mono">{{ number_format($param->param_b, 2) }}</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="text-sm font-black text-slate-800 font-mono">{{ number_format($param->param_c, 2) }}</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="text-sm font-black text-slate-800 font-mono">{{ number_format($param->param_d, 2) }}</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <button @click="editItem = {{ json_encode(['id' => $param->id, 'variable' => $variableName, 'label' => $param->linguistic_label->value, 'a' => $param->param_a, 'b' => $param->param_b, 'c' => $param->param_c, 'd' => $param->param_d]) }}; editModal = true"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-[#0d7a70] border border-[#0d7a70] rounded-xl hover:bg-[#0d7a70] hover:text-white transition-all">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

            @if($grouped->isEmpty())
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm py-16 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="p-4 bg-slate-50 rounded-full text-slate-300 mb-3">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <p class="text-slate-700 font-bold">Belum ada parameter fungsi keanggotaan</p>
                    <p class="text-slate-400 text-xs mt-1">Jalankan seeder untuk mengisi data awal.</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Edit Modal --}}
        <div x-show="editModal"
             class="fixed inset-0 overflow-hidden z-50"
             style="display:none;"
             x-transition>
            <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="editModal = false"></div>
            <div class="absolute inset-0 flex items-center justify-center p-4">
                <div x-show="editModal"
                     x-transition:enter="transform transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transform transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md p-8 relative">

                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-black text-slate-800">Edit Parameter</h3>
                            <p class="text-xs text-slate-400 mt-1">
                                <span class="font-bold text-slate-600" x-text="editItem ? ucfirstJs(editItem.variable) : ''"></span>
                                —
                                <span x-text="editItem ? editItem.label : ''"></span>
                            </p>
                        </div>
                        <button @click="editModal = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <template x-if="editItem">
                        <form :action="`/admin/fuzzy-memberships/${editItem.id}`" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-5 p-4 bg-amber-50 border border-amber-100 rounded-2xl">
                                <p class="text-[11px] text-amber-700 font-semibold leading-relaxed">
                                    ⚠️ Perubahan parameter ini akan langsung memengaruhi hasil inferensi fuzzy. Pastikan nilai a ≤ b ≤ c ≤ d.
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Parameter A</label>
                                    <input type="number" name="param_a" step="0.01" :value="editItem.a"
                                        class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] font-mono text-center">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Parameter B</label>
                                    <input type="number" name="param_b" step="0.01" :value="editItem.b"
                                        class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] font-mono text-center">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Parameter C</label>
                                    <input type="number" name="param_c" step="0.01" :value="editItem.c"
                                        class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] font-mono text-center">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Parameter D</label>
                                    <input type="number" name="param_d" step="0.01" :value="editItem.d"
                                        class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] font-mono text-center">
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button type="submit"
                                        class="flex-1 py-3 bg-[#0d7a70] text-white font-bold text-sm rounded-xl hover:bg-[#0a635b] transition-colors">
                                    Simpan Perubahan
                                </button>
                                <button type="button" @click="editModal = false"
                                        class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ucfirstJs(str) {
            if (!str) return '';
            return str.charAt(0).toUpperCase() + str.slice(1).replace(/_/g, ' ');
        }
    </script>
</x-admin-layout>
