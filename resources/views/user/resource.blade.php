<x-app-layout>
    {{-- Header --}}
    <div class="mb-8 max-w-3xl">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Pusat Resource Mahasiswa</h2>
        <p class="text-slate-500 text-sm leading-relaxed">
            Temukan panduan, latihan meditasi, dan artikel pilihan untuk menjaga kesehatan mental di masa perkuliahan.
        </p>
    </div>

    {{-- Filter Chips --}}
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('user.resource') }}" 
           class="px-5 py-2 rounded-full text-sm font-semibold transition-all {{ !request('category') ? 'bg-[#0d7a70] text-white shadow-md shadow-teal-100' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
            Semua
        </a>
        @foreach($categories as $category)
            <a href="{{ route('user.resource', ['category' => $category]) }}" 
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all capitalize {{ request('category') == $category ? 'bg-[#0d7a70] text-white shadow-md shadow-teal-100' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
                {{ $category }}
            </a>
        @endforeach
    </div>

    {{-- Grid Konten Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $article)
            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">
                {{-- Thumbnail / Visual Area --}}
                <div class="h-48 relative p-6 flex flex-col justify-between
                    @php
                        // Memberikan variasi warna background berdasarkan kategori
                        $bgClass = 'bg-[#f0f9fa] text-[#0d7a70]';
                        $badgeClass = 'bg-teal-100/80 text-teal-800';
                        $cat = strtolower($article->category);
                        if(str_contains($cat, 'audio') || str_contains($cat, 'meditasi')) {
                            $bgClass = 'bg-sky-50 text-sky-600';
                            $badgeClass = 'bg-sky-100 text-sky-800';
                        } elseif (str_contains($cat, 'video')) {
                            $bgClass = 'bg-indigo-50 text-indigo-600';
                            $badgeClass = 'bg-indigo-100 text-indigo-800';
                        } elseif (str_contains($cat, 'panduan')) {
                            $bgClass = 'bg-amber-50 text-amber-600';
                            $badgeClass = 'bg-amber-100 text-amber-800';
                        }
                    @endphp
                    {{ $bgClass }}
                ">
                    <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $badgeClass }} w-max self-start backdrop-blur-sm">
                        {{ $article->category }}
                    </span>
                    
                    <div class="flex-1 flex items-center justify-center">
                        {{-- Generic Icon based on category --}}
                        @if(str_contains($cat, 'audio') || str_contains($cat, 'meditasi'))
                            <svg class="w-16 h-16 opacity-70 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        @elseif (str_contains($cat, 'video'))
                            <svg class="w-16 h-16 opacity-70 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        @elseif (str_contains($cat, 'panduan'))
                            <svg class="w-16 h-16 opacity-70 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @else
                            <svg class="w-16 h-16 opacity-70 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        @endif
                    </div>
                </div>

                {{-- Content Area --}}
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2 leading-snug group-hover:text-[#0d7a70] transition-colors">
                        <a href="#">{{ $article->title }}</a>
                    </h3>
                    <p class="text-sm text-slate-500 mb-6 line-clamp-3 leading-relaxed flex-1">
                        {{ $article->excerpt }}
                    </p>
                    
                    <div class="flex items-center justify-between text-slate-400 pt-4 border-t border-slate-50 mt-auto">
                        <div class="flex items-center text-xs font-medium">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            5 Menit {{ str_contains($cat, 'video') || str_contains($cat, 'audio') ? 'Putar' : 'Baca' }}
                        </div>
                        <div class="flex items-center space-x-3">
                            <button class="hover:text-[#0d7a70] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg></button>
                            <button class="hover:text-[#0d7a70] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg></button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white border border-slate-100 rounded-[2rem]">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <p class="text-slate-500 font-medium">Belum ada resource atau artikel yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($articles->hasPages())
        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @endif
    
    {{-- Quote Section --}}
    <div class="mt-12 bg-white rounded-3xl border border-slate-100 p-8 flex items-start space-x-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-[0.03] text-[#0d7a70] -mt-10 -mr-10">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
        </div>
        <div class="bg-[#f0f9fa] text-[#0d7a70] rounded-full p-4 flex-shrink-0 z-10">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.039 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z"/></svg>
        </div>
        <div class="z-10">
            <p class="text-slate-600 font-medium italic text-lg leading-relaxed max-w-3xl mb-4">
                "Kesehatan mentalmu adalah prioritas. Istirahat sejenak bukanlah tanda kelemahan, melainkan bagian dari kekuatan untuk terus melangkah."
            </p>
            <p class="text-sm font-bold text-slate-800">— Pengingat Hari Ini</p>
        </div>
    </div>
</x-app-layout>
