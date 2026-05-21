<x-admin-layout title="Catatan Audit Sistem">
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

    <!-- Data Table Card -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider bg-slate-50/50">
                        <th class="py-4 px-6 w-44">Waktu Kejadian</th>
                        <th class="py-4 px-6 w-52">Administrator</th>
                        <th class="py-4 px-6 w-32 text-center">Metode Aksi</th>
                        <th class="py-4 px-6">Entitas/Rute Aksi</th>
                        <th class="py-4 px-6 w-44">Alamat IP</th>
                        <th class="py-4 px-6 w-64">Sistem / Perangkat (User Agent)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Timestamp -->
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700">{{ $log->created_at->format('d M Y, H:i:s') }}</span>
                                    <span class="text-[10px] text-slate-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            
                            <!-- Administrator Info -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img class="h-8 w-8 rounded-full border border-slate-200 object-cover" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode($log->admin->name ?? 'Admin') }}&background=f1f5f9&color=64748b" 
                                         alt="Avatar">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-700 leading-snug">{{ $log->admin->name ?? 'Unknown Admin' }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $log->admin->email ?? 'unknown@email.com' }}</span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- HTTP Method Action Badge -->
                            <td class="py-4 px-6 text-center">
                                @if($log->action === 'POST')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">CREATE ({{ $log->action }})</span>
                                @elseif(in_array($log->action, ['PUT', 'PATCH']))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100">UPDATE ({{ $log->action }})</span>
                                @elseif($log->action === 'DELETE')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100">DELETE ({{ $log->action }})</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider bg-slate-50 text-slate-600 border border-slate-100">{{ $log->action }}</span>
                                @endif
                            </td>
                            
                            <!-- Entity Type / Route -->
                            <td class="py-4 px-6 font-bold text-slate-700">
                                <div class="flex items-center gap-1.5 font-mono text-xs text-slate-600">
                                    <span class="text-slate-400">/</span>{{ $log->entity_type }}
                                </div>
                            </td>
                            
                            <!-- IP Address -->
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 bg-slate-150 rounded-xl text-xs font-bold text-slate-600 border border-slate-200/60 font-mono bg-slate-50">
                                    {{ $log->ip_address }}
                                </span>
                            </td>
                            
                            <!-- User Agent -->
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
                                    <p class="text-slate-400 text-xs mt-1 max-w-xs leading-relaxed">Catatan audit log masih kosong. Semua aktivitas operasional Admin (seperti memperbarui aturan) akan otomatis tercatat di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginasi Link -->
    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs">
        <div class="text-slate-400 font-medium">
            Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} log aktivitas
        </div>
        <div>
            {{ $logs->links() }}
        </div>
    </div>
</x-admin-layout>
