@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' - ' : '' }}{{ config('app.name', 'DepreSense') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-item-active {
            background-color: #ecf5f4;
            color: #0d7a70;
            border-right: 4px solid #0d7a70;
        }
    </style>
</head>
<body class="bg-slate-50 antialiased text-slate-800">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 flex-shrink-0 hidden md:flex flex-col fixed h-full">
            <div class="p-6">
                <h1 class="text-xl font-bold text-[#0d7a70] tracking-tight">DepreSense</h1>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest mt-1">Admin Management</p>
            </div>

            <nav class="flex-1 mt-4 overflow-y-auto">
                <ul class="space-y-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }} transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Pertanyaan -->
                    <li>
                        <a href="{{ route('admin.questions.index') }}" 
                        class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.questions.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }} transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pertanyaan
                        </a>
                    </li>

                    <!-- Aturan (Fuzzy) -->
                    <li>
                        <a href="{{ route('admin.fuzzy-rules.index') }}" 
                        class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.fuzzy-rules.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }} transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Aturan
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center text-sm font-medium text-rose-500 hover:text-rose-700">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content (Margin left 64 untuk offset sidebar fixed) -->
        <div class="flex-1 flex flex-col min-w-0 ml-64">
            <!-- Header/Navbar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-end px-8 space-x-5 sticky top-0 z-10">
                <button class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="flex items-center">
                    <span class="mr-3 text-sm font-semibold text-slate-700">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <img class="h-9 w-9 rounded-full border border-slate-200 bg-slate-100 object-cover" src="https://ui-avatars.com/api/?name=Admin&background=0d7a70&color=fff" alt="Avatar">
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>