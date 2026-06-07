<x-app-layout>

    <x-slot name="title">Riwayat | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Riwayat Penilaian</h2>
        <p class="text-slate-500 text-sm leading-relaxed max-w-2xl">
            Pantau hasil asesmen Anda dari waktu ke waktu. Mengenali pola adalah langkah pertama menuju kesejahteraan yang lebih baik.
        </p>
    </div>

    {{-- Filter Chips --}}
    <div class="flex flex-wrap gap-3 mb-8">
        @php
            $currentLevel = request('level', 'Semua');
            $filters = ['Semua', 'Ringan', 'Sedang', 'Berat'];
        @endphp
        
        @foreach($filters as $filter)
            <a href="{{ route('user.history', ['level' => $filter]) }}" 
               class="px-6 py-2 rounded-full text-sm font-semibold transition-all border {{ $currentLevel === $filter ? 'bg-[#0d7a70] text-white border-[#0d7a70] shadow-md shadow-teal-100' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
                {{ $filter }}
            </a>
        @endforeach
    </div>

    {{-- Tabel Riwayat --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] w-1/4">Tanggal</th>
                        <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] w-1/4">Skor & Tren</th>
                        <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] w-1/4">Kategori</th>
                        <th class="p-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] w-1/4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($sessions as $index => $session)
                        @php
                            // Calculate trend compared to previous session
                            $trendIcon = '<svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>';
                            $trendClass = 'bg-slate-50 text-slate-500';
                            
                            // If not the last item in pagination, compare with next one (which is older because we order by latest)
                            // For a more accurate trend, we need the actual previous session, but a simple approximation is fine for UI
                            // We can use random or calculate if we have previous data. Since we just have a paginated list, 
                            // let's compare with the next item in the collection if it exists
                            if (isset($sessions[$index + 1])) {
                                $prevScore = $sessions[$index + 1]->score_total;
                                if ($session->score_total > $prevScore) {
                                    $trendIcon = '<svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>';
                                    $trendClass = 'bg-rose-50 text-rose-600';
                                } elseif ($session->score_total < $prevScore) {
                                    $trendIcon = '<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>';
                                    $trendClass = 'bg-emerald-50 text-emerald-600';
                                }
                            }
                            
                            $levelStyles = match($session->depression_level?->value) {
                                'minimal' => 'bg-emerald-50 text-emerald-600',
                                'ringan'  => 'bg-[#e6f4f2] text-[#0d7a70]',
                                'sedang'  => 'bg-indigo-50 text-indigo-600',
                                'berat'   => 'bg-rose-50 text-rose-600',
                                default   => 'bg-slate-50 text-slate-500'
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-6">
                                <span class="font-bold text-slate-700 block">{{ $session->completed_at ? $session->completed_at->format('d F Y') : '-' }}</span>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center">
                                    <span class="text-xl font-extrabold text-slate-800 mr-3">{{ $session->score_total }}</span>
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $trendClass }}">
                                        {!! $trendIcon !!}
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $levelStyles }}">
                                    {{ $session->depression_level?->value ?? 'Darurat' }}
                                </span>
                            </td>
                            <td class="p-6 text-right">
                                <a href="{{ route('user.history.show', $session->id) }}" class="inline-flex items-center text-sm font-bold text-[#0d7a70] hover:text-[#0a635b] group-hover:underline">
                                    Detail
                                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center text-slate-500">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="font-medium">Belum ada riwayat penilaian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($sessions->hasPages())
        <div class="mt-6">
            {{ $sessions->links() }}
        </div>
    @endif
</x-app-layout>
