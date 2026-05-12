@props([
    'maxWidth' => 'sm:max-w-md'
])

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
    <body class="font-sans antialiased text-slate-900 bg-[#f0f9fa]">
        <div class="min-h-screen flex flex-col items-center py-12 px-4 overflow-y-auto">
            
            <div class="mb-8 text-center shrink-0">
                <a href="/">
                    <h1 class="text-4xl font-bold tracking-tight text-[#0d7a70]">DepreSense</h1>
                </a>
            </div>

            <div class="w-full {{ $maxWidth }} my-auto px-6 md:px-10 py-8 bg-white shadow-[0_10px_40px_rgb(0,0,0,0.04)] border border-slate-100 rounded-[2.5rem] transition-all duration-500">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
