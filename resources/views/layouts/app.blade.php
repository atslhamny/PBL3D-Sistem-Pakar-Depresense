<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DepreSense') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-item-active {
            background-color: #f0f9fa;
            color: #0d7a70;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-[#f8fafc] antialiased text-slate-800">
    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-white border-r border-slate-100 flex-shrink-0 hidden md:flex flex-col fixed h-full z-20">
            <div class="p-6">
                <h1 class="text-xl font-bold text-[#0d7a70] tracking-tight">DepreSense</h1>
                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Digital Sanctuary</p>
            </div>

            <nav class="flex-1 px-4 mt-2 space-y-1 overflow-y-auto">
                <a href="{{ route('user.dashboard') }}" {{-- <- Pastikan nama route ini sesuai dengan route dashboard Anda --}}
                    class="flex items-center px-4 py-3 text-sm rounded-xl transition-colors {{ request()->routeIs('*dashboard*') ? 'nav-item-active' : 'text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70]' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    Home
                </a>

                <a href="#" 
                   class="flex items-center px-4 py-3 text-sm rounded-xl text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Assessment
                </a>

                <a href="#" 
                   class="flex items-center px-4 py-3 text-sm rounded-xl text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Resource
                </a>

                <a href="#" 
                   class="flex items-center px-4 py-3 text-sm rounded-xl text-slate-500 hover:bg-slate-50 hover:text-[#0d7a70] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    History
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="w-full flex items-center p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 transition-all text-left focus:outline-none relative group">
                    <img class="h-10 w-10 rounded-full object-cover border border-slate-200 bg-white" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0d7a70&color=fff" 
                         alt="Avatar">
                    <div class="ml-3 overflow-hidden flex-1">
                        <p class="text-sm font-bold text-slate-700 truncate">{{ Auth::user()->full_name}}</p>
                        <p class="text-[11px] text-slate-400 font-medium truncate">Teknologi Informasi</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="transform opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="transform opacity-0 translate-y-2 scale-95"
                     class="absolute bottom-20 left-4 w-56 bg-white border border-slate-100 rounded-xl shadow-xl z-30 py-1 divide-y divide-slate-50"
                     style="display: none;">
                    
                    <div class="py-1">
                        <a href="#" class="flex items-center px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 font-medium transition-colors">
                            <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 01-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile Saya
                        </a>
                    </div>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-rose-500 hover:bg-rose-50 font-semibold transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 md:ml-64">
            
            <header class="h-16 bg-white/80 backdrop-blur-md flex items-center justify-end px-8 space-x-4 sticky top-0 z-10">

                <div class="h-6 w-px bg-slate-200 mx-1"></div>

                <img class="h-8 w-8 rounded-full border border-slate-200 bg-slate-100 object-cover" 
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0d7a70&color=fff" 
                     alt="Avatar">
            </header>

            <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>