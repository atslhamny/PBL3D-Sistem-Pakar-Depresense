<x-admin-layout title="Detail Artikel">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.articles.index') }}" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="text-2xl font-bold text-slate-800">Detail Artikel</h2>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.articles.edit', $article) }}" class="inline-flex items-center px-4 py-2 bg-white text-[#0d7a70] border border-[#0d7a70] text-sm font-semibold rounded-xl hover:bg-[#0d7a70] hover:text-white transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Artikel
            </a>
            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-50 text-rose-600 border border-rose-200 text-sm font-semibold rounded-xl hover:bg-rose-600 hover:text-white transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden p-8 md:p-12">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 bg-[#ecf5f4] text-[#0d7a70] rounded-lg text-[10px] font-bold uppercase tracking-wider">{{ $article->category }}</span>
                    @if($article->status === 'published')
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">Diterbitkan</span>
                    @else
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-200">Draf</span>
                    @endif
                </div>
                
                <h1 class="text-3xl md:text-4xl font-black text-slate-800 leading-tight mb-4">
                    {{ $article->title }}
                </h1>
                
                <div class="flex items-center gap-4 text-sm text-slate-500 border-b border-slate-100 pb-8 mb-8">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[#0d7a70] font-bold">
                            {{ substr($article->author->full_name ?? 'Admin', 0, 1) }}
                        </div>
                        <span class="font-semibold text-slate-700">{{ $article->author->full_name ?? 'Admin' }}</span>
                    </div>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $article->published_at ? $article->published_at->format('d M Y, H:i') : 'Belum diterbitkan' }}
                    </span>
                </div>
                
                @if($article->excerpt)
                <div class="text-lg font-medium text-slate-600 mb-8 leading-relaxed italic border-l-4 border-[#0d7a70] pl-4">
                    {{ $article->excerpt }}
                </div>
                @endif
                
                <div class="prose prose-slate prose-lg max-w-none prose-headings:font-bold prose-headings:text-slate-800 prose-a:text-[#0d7a70] prose-img:rounded-2xl prose-img:shadow-sm">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
