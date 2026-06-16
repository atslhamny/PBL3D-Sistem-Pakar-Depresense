<x-guest-layout>

    <x-slot name="title">Register | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

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
                <x-input-error :messages="$errors->get('university')" class="mt-2" />
            </div>
            <div>
                <label for="semester" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Semester</label>
                <input id="semester" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" type="number" min="1" max="14" name="semester" :value="old('semester')" placeholder="Contoh: 4" />
                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
            </div>
        </div>

        <div class="mb-4">
            <label for="study_program" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Program Studi</label>
            <input id="study_program" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" type="text" name="study_program" :value="old('study_program')" placeholder="Contoh: Sistem Informasi" />
            <x-input-error :messages="$errors->get('study_program')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label for="email" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Email</label>
            <input id="email" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" type="email" name="email" :value="old('email')" placeholder="contoh: budi@mahasiswa.ac.id" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label for="password" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Password</label>
            <div class="relative">
                <input id="password" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm"
                                :type="showPw ? 'text' : 'password'"
                                name="password" placeholder="contoh: rahasia123 (minimal 8 karakter)"
                                required autocomplete="new-password" />
                <button type="button" @click="showPw = !showPw" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-[#00aba9] focus:outline-none transition-colors">
                    <svg x-show="!showPw" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                    <svg x-show="showPw" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
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
                <button type="button" @click="showConfirmPw = !showConfirmPw" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-[#00aba9] focus:outline-none transition-colors">
                    <svg x-show="!showConfirmPw" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                    <svg x-show="showConfirmPw" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
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