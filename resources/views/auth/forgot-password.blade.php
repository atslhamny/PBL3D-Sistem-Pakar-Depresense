<x-guest-layout>

    <x-slot name="title">Lupa Password | DepreSense</x-slot>

    <div class="w-full bg-white"> </div>

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Lupa Password?</h2>
        <p class="text-[13px] text-slate-500 leading-relaxed px-2">
            Tidak masalah. Cukup masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset password Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-6">
            <label for="email" class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Email Anda</label>
            <input id="email" 
                   class="block w-full px-4 py-3 bg-slate-50 border-slate-100 focus:border-[#00aba9] focus:ring-[#00aba9] rounded-2xl shadow-sm text-sm" 
                   type="email" name="email" :value="old('email')" 
                   placeholder="contoh: budi@mahasiswa.ac.id" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button class="w-full py-4 text-center text-white bg-[#00aba9] hover:bg-[#0d7a70] rounded-2xl font-bold transition-all shadow-md shadow-teal-100 active:scale-[0.98]">
                Kirim Link Reset Password
            </button>
        </div>
        
        <div class="mt-6 text-center">
            <a class="text-sm text-slate-500 hover:text-slate-700 font-medium transition-colors" href="{{ route('login') }}">
                Kembali ke halaman <span class="text-[#00aba9] font-bold">Login</span>
            </a>
        </div>
    </form>
</x-guest-layout>
