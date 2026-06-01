<x-app-layout>
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Profile Saya</h2>
        <p class="text-slate-500 text-sm leading-relaxed">
            Kelola informasi profil, preferensi, dan keamanan akun Anda.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Kolom Kiri: Navigasi Profil --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col items-center text-center">
                <img class="h-24 w-24 rounded-full object-cover border-4 border-slate-50 bg-slate-100 mb-4 shadow-sm" 
                     src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name ?? $user->name ?? 'User') }}&background=0d7a70&color=fff&size=128" 
                     alt="Avatar">
                <h3 class="text-lg font-bold text-slate-800">{{ $user->full_name }}</h3>
                <p class="text-sm font-medium text-[#0d7a70] mt-1">{{ $user->email }}</p>
                <div class="mt-4 pt-4 border-t border-slate-50 w-full">
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">Mahasiswa</p>
                    <p class="text-sm font-semibold text-slate-600 mt-1">{{ $user->study_program ?? 'Program Studi Belum Diatur' }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-2">
                <nav class="space-y-1">
                    <a href="#informasi-profil" class="flex items-center px-4 py-3 text-sm font-bold text-[#0d7a70] bg-[#f0f9fa] rounded-2xl transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 01-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Profil
                    </a>
                    <a href="#ubah-password" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-500 hover:text-[#0d7a70] hover:bg-slate-50 rounded-2xl transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Ubah Password
                    </a>
                    <a href="#hapus-akun" class="flex items-center px-4 py-3 text-sm font-semibold text-rose-500 hover:bg-rose-50 rounded-2xl transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Akun
                    </a>
                </nav>
            </div>
        </div>

        {{-- Kolom Kanan: Form --}}
        <div class="lg:col-span-2 space-y-6">
            
            <div id="informasi-profil" class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 sm:p-10">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div id="ubah-password" class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 sm:p-10">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div id="hapus-akun" class="bg-rose-50/50 rounded-[2rem] border border-rose-100 shadow-sm p-6 sm:p-10">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
