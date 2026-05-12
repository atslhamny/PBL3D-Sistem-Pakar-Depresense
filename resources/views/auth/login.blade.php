<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <div class="flex bg-slate-100/50 p-1 rounded-2xl mb-6">
            <a href="{{ route('login') }}" class="flex-1 py-2 text-sm font-medium bg-white text-[#00aba9] rounded-xl shadow-sm text-center">Login</a>
            <a href="{{ route('register') }}" class="flex-1 py-2 text-sm font-medium text-slate-500 text-center">Daftar</a>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Email</label>
            <input id="email" 
                   class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" 
                   type="email" name="email" :value="old('email')" 
                   placeholder="Masukkan Email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <div class="flex justify-between items-center mb-1 ml-1">
                <label for="password" class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-[#00aba9] hover:text-[#0d7a70]" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            
            <div class="relative">
                <input id="password" 
                       class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm"
                       :type="showPassword ? 'text' : 'password'"
                       name="password"
                       placeholder="••••••••"
                       required autocomplete="current-password" />
                
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.13-5.247M10 10a3 3 0 013 3m3 3a9 9 0 01-14.12-14.12M15 15l6 6m-6-6l1.125-1.125M19.172 19.172L21 21M3 3l1.828 1.828"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4 ml-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-300 text-[#00aba9] shadow-sm focus:ring-[#00aba9]" name="remember">
                <span class="ms-2 text-sm text-slate-500">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="mt-8">
            <button class="w-full py-4 text-center text-white bg-[#00aba9] hover:bg-[#0d7a70] rounded-2xl font-bold transition-all shadow-md shadow-teal-100 active:scale-[0.98]">
                Login
            </button>
        </div>
    </form>
</x-guest-layout>