<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DepreSense') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50 dark:bg-slate-900 dark:text-slate-100 selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-slate-900 dark:via-slate-800 dark:to-indigo-950">
            <div>
                <a href="/">
                    <h1 class="text-4xl font-extrabold tracking-tight text-indigo-600 dark:text-indigo-400">Depre<span class="text-cyan-500">Sense</span></h1>
                </a>
            </div>

            <div class="w-full sm:max-w-xl mt-8 px-8 py-10 bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-3xl border border-white/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-indigo-500/10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
