<x-admin-layout title="Manajemen Pengguna">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola data mahasiswa dan hasil skrining kesehatan mental mereka.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 bg-[#ecf5f4] text-[#0d7a70] text-xs font-black rounded-xl border border-teal-100">
                {{ $totalUsers }} Total Pengguna
            </span>
        </div>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-emerald-100 text-emerald-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <p class="text-xs font-bold text-emerald-800">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif

    {{-- Metric Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-[#ecf5f4] rounded-2xl text-[#0d7a70]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                <p class="text-2xl font-black text-slate-800">{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-rose-50 rounded-2xl text-rose-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perlu Perhatian</p>
                <p class="text-2xl font-black text-rose-600">{{ $perluPerhatianCount }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-slate-100 rounded-2xl text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Belum Skrining</p>
                <p class="text-2xl font-black text-slate-700">{{ $belumScreeningCount }}</p>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row gap-3">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-1 gap-3 flex-wrap">
                <div class="relative flex-1 min-w-[200px]">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-1 focus:ring-[#0d7a70]/20 transition-colors">
                </div>
                <select name="status" class="px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] bg-white text-slate-600 font-medium">
                    <option value="">Semua Status</option>
                    <option value="perlu_perhatian" {{ request('status') === 'perlu_perhatian' ? 'selected' : '' }}>Perlu Perhatian</option>
                    <option value="stabil" {{ request('status') === 'stabil' ? 'selected' : '' }}>Stabil</option>
                    <option value="belum_screening" {{ request('status') === 'belum_screening' ? 'selected' : '' }}>Belum Skrining</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-[#0d7a70] text-white text-sm font-semibold rounded-xl hover:bg-[#0a635b] transition-colors">
                    Cari
                </button>
                @if(request('search') || request('status'))
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                    Reset
                </a>
                @endif
            </form>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider bg-slate-50/50">
                        <th class="py-4 px-6">Nama Pengguna</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Universitas</th>
                        <th class="py-4 px-6 text-center">Total Skrining</th>
                        <th class="py-4 px-6">Skrining Terakhir</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            {{-- Avatar + Name --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-full bg-[#ecf5f4] border border-teal-100 text-[#0d7a70] font-black text-sm flex items-center justify-center flex-shrink-0">
                                        {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $user->full_name }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $user->study_program ?? '-' }}, Sem. {{ $user->semester ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-500 text-xs">{{ $user->email }}</td>
                            <td class="py-4 px-6 text-slate-500 text-xs max-w-[150px] truncate">{{ $user->university ?? '-' }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="text-sm font-bold text-slate-700">{{ $user->screening_sessions_count }}</span>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500">
                                @if($user->last_session)
                                    <div>
                                        <p class="font-semibold text-slate-700">{{ $user->last_session->created_at->format('d M Y, H:i') }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $user->last_session->created_at->diffForHumans() }}</p>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Belum ada</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $status = $user->user_status;
                                    $badgeClass = match($status) {
                                        'Darurat' => 'bg-rose-100 text-rose-700 border-rose-200 animate-pulse',
                                        'Perlu Perhatian' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'Stabil' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        default => 'bg-blue-50 text-blue-600 border-blue-100'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider border {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-[#0d7a70] hover:text-white hover:bg-[#0d7a70] border border-[#0d7a70] rounded-xl transition-all">
                                    Lihat Detail
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="p-4 bg-slate-50 rounded-full text-slate-300 mb-3">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <p class="text-slate-700 font-bold text-sm">Tidak ada pengguna ditemukan</p>
                                    <p class="text-slate-400 text-xs mt-1">Coba ubah filter atau kata kunci pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
            <span>Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna</span>
            {{ $users->links() }}
        </div>
        @else
        <div class="p-5 border-t border-slate-100 text-xs text-slate-400">
            Menampilkan {{ $users->count() }} dari {{ $users->total() }} pengguna
        </div>
        @endif
    </div>
</x-admin-layout>
