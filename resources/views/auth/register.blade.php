<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="flex bg-slate-100/50 p-1 rounded-2xl mb-6">
            <a href="{{ route('login') }}" class="flex-1 py-2 text-sm font-medium text-slate-500 text-center">Login</a>
            <a href="{{ route('register') }}" class="flex-1 py-2 text-sm font-medium bg-white text-[#00aba9] rounded-xl shadow-sm text-center">Daftar</a>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ showPw: false, showConfirmPw: false }">
        @csrf

        <div class="mb-4">
            <label for="full_name" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Nama Lengkap</label>
            <input id="full_name" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" type="text" name="full_name" :value="old('full_name')" placeholder="Nama lengkap Anda" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="university" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Universitas</label>
                <input id="university" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" type="text" name="university" :value="old('university')" placeholder="Nama kampus" autocomplete="organization" />
            </div>
            <div>
                <label for="semester" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Semester</label>
                <input id="semester" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" type="number" min="1" max="14" name="semester" :value="old('semester')" placeholder="Contoh: 4" />
            </div>
        </div>

        <div class="mb-4">
            <label for="study_program" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Program Studi</label>
            <input id="study_program" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" type="text" name="study_program" :value="old('study_program')" placeholder="Contoh: Sistem Informasi" />
        </div>

        <div class="mb-4">
            <label for="email" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Email</label>
            <input id="email" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" type="email" name="email" :value="old('email')" placeholder="nama@email.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label for="password" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Password</label>
            <div class="relative">
                <input id="password" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm"
                                :type="showPw ? 'text' : 'password'"
                                name="password" placeholder="Minimal 8 karakter"
                                required autocomplete="new-password" />
                <button type="button" @click="showPw = !showPw" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400">
                    <svg x-show="!showPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="showPw" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.13-5.247M10 10a3 3 0 013 3m3 3a9 9 0 01-14.12-14.12M15 15l6 6m-6-6l1.125-1.125M19.172 19.172L21 21M3 3l1.828 1.828"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Konfirmasi Password</label>
            <div class="relative">
                <input id="password_confirmation" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm"
                                :type="showConfirmPw ? 'text' : 'password'"
                                name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password" />
                <button type="button" @click="showConfirmPw = !showConfirmPw" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400">
                    <svg x-show="!showConfirmPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="showConfirmPw" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.13-5.247M10 10a3 3 0 013 3m3 3a9 9 0 01-14.12-14.12M15 15l6 6m-6-6l1.125-1.125M19.172 19.172L21 21M3 3l1.828 1.828"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4">
            <button class="w-full py-4 text-center text-white bg-[#00aba9] hover:bg-[#0d7a70] rounded-2xl font-bold transition-all shadow-md shadow-teal-100 active:scale-[0.98]">
                Daftar Akun
            </button>

            <div class="text-center">
                <a class="text-sm text-slate-500 hover:text-slate-700 font-medium transition-colors" href="{{ route('login') }}">
                    Sudah punya akun? <span class="text-[#00aba9] font-bold">Masuk sekarang</span>
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>