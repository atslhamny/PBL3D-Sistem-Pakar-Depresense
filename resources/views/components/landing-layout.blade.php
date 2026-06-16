<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'DepreSense - Sistem Pakar Manajemen Kesehatan Mental' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased text-slate-800 min-h-screen flex flex-col justify-between">

    <div class="w-full flex-grow">
        {{ $slot }}
    </div>

</body>
</html>