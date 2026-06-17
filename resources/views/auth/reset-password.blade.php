<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Buat Password Baru</h2>
        <p class="text-[13px] text-slate-500 px-2">
            Silakan buat password baru untuk akun Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" x-data="{ showPw: false, showConfirmPw: false }">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Email Anda</label>
            <input id="email" 
                   class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" 
                   type="email" name="email" :value="old('email', $request->email)" 
                   required autofocus autocomplete="username" readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Password Baru</label>
            <div class="relative">
                <input id="password" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm"
                                :type="showPw ? 'text' : 'password'"
                                name="password" placeholder="(minimal 8 karakter)"
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

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Konfirmasi Password Baru</label>
            <div class="relative">
                <input id="password_confirmation" class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm"
                                :type="showConfirmPw ? 'text' : 'password'"
                                name="password_confirmation" placeholder="Ulangi password baru" required autocomplete="new-password" />
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

        <div class="mt-6">
            <button class="w-full py-4 text-center text-white bg-[#00aba9] hover:bg-[#0d7a70] rounded-2xl font-bold transition-all shadow-md shadow-teal-100 active:scale-[0.98]">
                Simpan Password Baru
            </button>
        </div>
    </form>
</x-guest-layout>
