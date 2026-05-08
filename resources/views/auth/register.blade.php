<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <div>
            <x-input-label for="full_name" :value="__('Nama Lengkap')" />
            <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- University -->
        <div class="mt-4">
            <x-input-label for="university" :value="__('Universitas (Opsional)')" />
            <x-text-input id="university" class="block mt-1 w-full" type="text" name="university" :value="old('university')" autocomplete="organization" />
            <x-input-error :messages="$errors->get('university')" class="mt-2" />
        </div>

        <!-- Study Program -->
        <div class="mt-4">
            <x-input-label for="study_program" :value="__('Program Studi (Opsional)')" />
            <x-text-input id="study_program" class="block mt-1 w-full" type="text" name="study_program" :value="old('study_program')" />
            <x-input-error :messages="$errors->get('study_program')" class="mt-2" />
        </div>

        <!-- Semester -->
        <div class="mt-4">
            <x-input-label for="semester" :value="__('Semester (Opsional)')" />
            <x-text-input id="semester" class="block mt-1 w-full" type="number" min="1" max="14" name="semester" :value="old('semester')" />
            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
