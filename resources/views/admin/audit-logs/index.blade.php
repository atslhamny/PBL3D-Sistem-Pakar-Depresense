<x-admin-layout>

    <x-slot name="title">Catatan Audit Sistem | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Catatan Audit Sistem</h2>
            <p class="text-slate-500 text-sm mt-1">Pantau rekaman riwayat aktivitas operasional penting yang dilakukan oleh Admin.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-slate-400">Total Aktivitas:</span>
            <span class="px-3 py-1.5 bg-[#ecf5f4] text-[#0d7a70] text-xs font-black rounded-xl border border-teal-100">
                {{ $logs->total() }} Log Tercatat
            </span>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden mb-0">
        <div class="p-5 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="flex flex-wrap gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari entitas atau rute..."
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-1 focus:ring-[#0d7a70]/20 transition-colors">
                </div>
                <select name="method" class="px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] bg-white text-slate-600 font-medium">
                    <option value="">Semua Metode</option>
                    <option value="POST" {{ request('method') === 'POST' ? 'selected' : '' }}>POST (Create)</option>
                    <option value="PUT" {{ request('method') === 'PUT' ? 'selected' : '' }}>PUT (Update)</option>
                    <option value="PATCH" {{ request('method') === 'PATCH' ? 'selected' : '' }}>PATCH (Update)</option>
                    <option value="DELETE" {{ request('method') === 'DELETE' ? 'selected' : '' }}>DELETE (Hapus)</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-[#0d7a70] text-white text-sm font-semibold rounded-xl hover:bg-[#0a635b] transition-colors">
                    Cari
                </button>
                @if(request('search') || request('method'))
                <a href="{{ route('admin.audit-logs.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                    Reset
                </a>
                @endif
            </form>
        </div>

        {{-- Data Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider bg-slate-50/50">
                        <th class="py-4 px-6 w-44">Waktu Kejadian</th>
                        <th class="py-4 px-6 w-52">Administrator</th>
                        <th class="py-4 px-6 w-32 text-center">Metode Aksi</th>
                        <th class="py-4 px-6">Entitas/Rute Aksi</th>
                        <th class="py-4 px-6 w-44">Alamat IP</th>
                        <th class="py-4 px-6 w-64">Sistem / Perangkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            {{-- Timestamp --}}
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700">{{ $log->created_at->format('d M Y, H:i:s') }}</span>
                                    <span class="text-[10px] text-slate-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            
                            {{-- Administrator Info --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-[#ecf5f4] border border-teal-100 text-[#0d7a70] font-black text-xs flex items-center justify-center flex-shrink-0">
                                        {{ strtoupper(substr($log->admin->full_name ?? $log->admin->name ?? 'A', 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-700 leading-snug">{{ $log->admin->full_name ?? $log->admin->name ?? 'Unknown Admin' }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $log->admin->email ?? 'unknown@email.com' }}</span>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- HTTP Method --}}
                            <td class="py-4 px-6 text-center">
                                @php
                                    $methodLabel = match($log->action) {
                                        'POST' => 'CREATE',
                                        'PUT', 'PATCH' => 'UPDATE',
                                        'DELETE' => 'DELETE',
                                        default => $log->action,
                                    };
                                    $methodClass = match($log->action) {
                                        'POST' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'PUT', 'PATCH' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'DELETE' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider border {{ $methodClass }}">
                                    {{ $methodLabel }}
                                </span>
                            </td>
                            
                            {{-- Entity Type --}}
                            <td class="py-4 px-6 font-bold text-slate-700">
                                <div class="flex items-center gap-1.5 font-mono text-xs text-slate-600">
                                    <span class="text-slate-400">/</span>{{ $log->entity_type }}
                                    @if($log->entity_id)
                                    <span class="text-slate-300">#{{ $log->entity_id }}</span>
                                    @endif
                                </div>
                            </td>
                            
                            {{-- IP Address --}}
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-200/60 font-mono">
                                    {{ $log->ip_address }}
                                </span>
                            </td>
                            
                            {{-- User Agent --}}
                            <td class="py-4 px-6 text-xs text-slate-400 max-w-[200px] truncate" title="{{ $log->user_agent }}">
                                {{ $log->user_agent }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 px-6 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="p-4 bg-slate-50 rounded-full text-slate-400 mb-3 border border-slate-100">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <h4 class="text-slate-700 font-bold text-sm">Belum Ada Log Aktivitas</h4>
                                    <p class="text-slate-400 text-xs mt-1 max-w-xs leading-relaxed">Catatan audit log masih kosong. Semua aktivitas operasional Admin akan otomatis tercatat di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginasi --}}
        <div class="p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <div>
                Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} log aktivitas
            </div>
            <div>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
