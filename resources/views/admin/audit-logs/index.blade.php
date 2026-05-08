<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Audit Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 text-gray-900 dark:text-gray-100">
                <p>Catatan Audit Sistem dalam pengembangan.</p>
                <div class="mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
