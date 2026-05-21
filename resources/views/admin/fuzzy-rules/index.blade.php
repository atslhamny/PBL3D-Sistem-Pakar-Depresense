<x-admin-layout title="Manajemen Aturan (Sistem Pakar)">
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Manajemen Aturan (Sistem Pakar)</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola logika inferensi fuzzy "JIKA... MAKA..." untuk diagnosis tingkat depresi secara dinamis.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-slate-400">Terakhir Diperbarui:</span>
                <span class="px-3 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl border border-slate-200">
                    {{ \App\Models\FuzzyRule::max('updated_at') ? \Carbon\Carbon::parse(\App\Models\FuzzyRule::max('updated_at'))->diffForHumans() : 'Belum diperbarui' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Alert Box Notifikasi Sukses -->
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

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Aturan -->
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

        <!-- Aturan Aktif -->
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

        <!-- Aturan Non-aktif -->
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

    <!-- Data Table Card -->
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
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($rules as $rule)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Rule Number -->
                            <td class="py-5 px-6 font-black text-slate-800">
                                R{{ sprintf('%03d', $rule->rule_number) }}
                            </td>
                            
                            <!-- Antecedents (JIKA) -->
                            <td class="py-5 px-6">
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium text-slate-600">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Total BDI:</span>
                                        <span class="font-bold {{ $rule->antecedent_total->value === 'berat' ? 'text-rose-500' : ($rule->antecedent_total->value === 'sedang' ? 'text-amber-500' : ($rule->antecedent_total->value === 'ringan' ? 'text-indigo-500' : 'text-emerald-500')) }}">
                                            {{ ucfirst($rule->antecedent_total->value) }}
                                        </span>
                                    </div>
                                    <span class="text-[9px] font-black text-slate-300">AND</span>
                                    
                                    <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium text-slate-600">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Kognitif-Afektif:</span>
                                        <span class="font-bold {{ $rule->antecedent_cognitive->value === 'berat' ? 'text-rose-500' : ($rule->antecedent_cognitive->value === 'sedang' ? 'text-amber-500' : ($rule->antecedent_cognitive->value === 'ringan' ? 'text-indigo-500' : 'text-emerald-500')) }}">
                                            {{ ucfirst($rule->antecedent_cognitive->value) }}
                                        </span>
                                    </div>
                                    <span class="text-[9px] font-black text-slate-300">AND</span>

                                    <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium text-slate-600">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Somatik:</span>
                                        <span class="font-bold {{ $rule->antecedent_somatic->value === 'berat' ? 'text-rose-500' : ($rule->antecedent_somatic->value === 'sedang' ? 'text-amber-500' : ($rule->antecedent_somatic->value === 'ringan' ? 'text-indigo-500' : 'text-emerald-500')) }}">
                                            {{ ucfirst($rule->antecedent_somatic->value) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Consequent (MAKA) -->
                            <td class="py-5 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold border uppercase tracking-wider
                                    {{ $rule->consequent->value === 'berat' ? 'bg-rose-50 text-rose-600 border-rose-100' : 
                                       ($rule->consequent->value === 'sedang' ? 'bg-amber-50 text-amber-600 border-amber-100' : 
                                       ($rule->consequent->value === 'ringan' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 
                                                                               'bg-emerald-50 text-emerald-600 border-emerald-100')) }}">
                                    {{ $rule->consequent->value }}
                                </span>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-5 px-6">
                                @if($rule->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-slate-100 text-slate-400 border border-slate-200">Non-aktif</span>
                                @endif
                            </td>

                            <!-- Action Switch -->
                            <td class="py-5 px-6 text-center">
                                <form action="{{ route('admin.fuzzy-rules.update', $rule->id) }}" method="POST" class="inline-block align-middle">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_active" value="{{ $rule->is_active ? 0 : 1 }}">
                                    <button type="submit" 
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $rule->is_active ? 'bg-[#0d7a70]' : 'bg-slate-200' }}"
                                            title="{{ $rule->is_active ? 'Klik untuk menonaktifkan aturan ini' : 'Klik untuk mengaktifkan aturan ini' }}">
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $rule->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-slate-400 italic">
                                Belum ada aturan fuzzy yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>