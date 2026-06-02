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

                    <!-- Pengguna -->
                    <li>
                        <a href="{{ route('admin.users.index') }}" 
                        class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }} transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Pengguna
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

                    <!-- Aturan (Fuzzy Rules) -->
                    <li>
                        <a href="{{ route('admin.fuzzy-rules.index') }}" 
                        class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.fuzzy-rules.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }} transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Aturan
                        </a>
                    </li>

                    <!-- Fungsi Keanggotaan -->
                    <li>
                        <a href="{{ route('admin.fuzzy-memberships.index') }}" 
                        class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.fuzzy-memberships.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }} transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Keanggotaan Fuzzy
                        </a>
                    </li>

                    <!-- Artikel -->
                    <li>
                        <a href="{{ route('admin.articles.index') }}" 
                        class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.articles.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }} transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Artikel
                        </a>
                    </li>

                    <!-- Log Sistem (Catatan Audit) -->
                    <li>
                        <a href="{{ route('admin.audit-logs.index') }}" 
                        class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.audit-logs.*') ? 'sidebar-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }} transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Log Sistem
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

        <!-- Main Content (Responsive margin-left) -->
        <div class="flex-1 flex flex-col min-w-0 md:ml-64 w-full">
            
            <!-- Header/Navbar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-end px-8 space-x-5 sticky top-0 z-10 print:hidden">

                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none group">
                        <span class="text-sm font-semibold text-slate-700 group-hover:text-[#0d7a70] transition-colors">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </span>
                        <div class="relative">
                            <img class="h-9 w-9 rounded-full border border-slate-200 bg-slate-100 object-cover group-hover:border-[#0d7a70] transition-colors" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=0d7a70&color=fff" 
                                 alt="Avatar">
                            <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-400 ring-2 ring-white"></span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#0d7a70] transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg z-50 py-1 divide-y divide-slate-50"
                         style="display: none;">
                        
                        <div class="px-4 py-2.5">
                            <p class="text-xs text-slate-400 font-medium">Masuk sebagai</p>
                            <p class="text-sm font-bold text-slate-700 truncate">{{ Auth::user()->email ?? 'admin@depresense.com' }}</p>
                        </div>

                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-rose-500 hover:bg-rose-50 font-semibold transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
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