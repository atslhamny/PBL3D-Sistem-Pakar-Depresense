<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="full_name" :value="__('Nama Lengkap')" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $user->full_name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
        </div>

        <div>
            <x-input-label for="university" :value="__('Universitas')" />
            <x-text-input id="university" name="university" type="text" class="mt-1 block w-full" :value="old('university', $user->university)" autocomplete="organization" />
            <x-input-error class="mt-2" :messages="$errors->get('university')" />
        </div>

        <div>
            <x-input-label for="study_program" :value="__('Program Studi')" />
            <x-text-input id="study_program" name="study_program" type="text" class="mt-1 block w-full" :value="old('study_program', $user->study_program)" />
            <x-input-error class="mt-2" :messages="$errors->get('study_program')" />
        </div>

        <div>
            <x-input-label for="semester" :value="__('Semester')" />
            <x-text-input id="semester" name="semester" type="number" min="1" max="14" class="mt-1 block w-full" :value="old('semester', $user->semester)" />
            <x-input-error class="mt-2" :messages="$errors->get('semester')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 4000)" {{-- Durasi tampil 4 detik agar sempat terbaca --}}
                    x-transition:enter="transform ease-out duration-300 transition"
                    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-emerald-50 border border-emerald-200 shadow-xl rounded-2xl p-4 flex items-center justify-between pointer-events-auto"
                >
                    <div class="flex items-center gap-3">
                        {{-- Ikon Centang Sukses --}}
                        <div class="p-2 bg-emerald-500 text-white rounded-xl shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-emerald-900">Berhasil Disimpan!</p>
                            <p class="text-xs text-emerald-600 mt-0.5">Informasi profil Anda telah diperbarui.</p>
                        </div>
                    </div>
                    
                    {{-- Tombol Tutup Manual --}}
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 p-1 rounded-lg transition-colors ml-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </form>
</section>
