<x-admin-layout :title="'Edit Artikel — ' . $article->title">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.articles.index') }}"
           class="p-2.5 bg-white border border-slate-200 text-slate-500 hover:text-[#0d7a70] hover:border-[#0d7a70] rounded-xl transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Edit Artikel</h2>
            <p class="text-sm text-slate-400 mt-0.5 truncate max-w-md">{{ $article->title }}</p>
        </div>
    </div>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Artikel <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $article->title) }}"
                        class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-1 focus:ring-[#0d7a70]/20 transition-colors @error('title') border-rose-300 @enderror">
                    @error('title')<p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" rows="2"
                        class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-1 focus:ring-[#0d7a70]/20 transition-colors resize-none @error('excerpt') border-rose-300 @enderror">{{ old('excerpt', $article->excerpt) }}</textarea>
                    @error('excerpt')<p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konten Artikel <span class="text-rose-500">*</span></label>
                    <textarea name="content" rows="16"
                        class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] focus:ring-1 focus:ring-[#0d7a70]/20 transition-colors resize-y @error('content') border-rose-300 @enderror">{{ old('content', $article->content) }}</textarea>
                    @error('content')<p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Pengaturan Publikasi</h4>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:border-[#0d7a70] hover:bg-[#ecf5f4]/50 transition-all has-[:checked]:border-[#0d7a70] has-[:checked]:bg-[#ecf5f4]/40">
                            <input type="radio" name="status" value="published" {{ old('status', $article->status) === 'published' ? 'checked' : '' }} class="accent-[#0d7a70]">
                            <div>
                                <p class="text-sm font-bold text-slate-700">Terbitkan</p>
                                <p class="text-xs text-slate-400">Artikel tampil ke pengguna</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:border-amber-400 hover:bg-amber-50/50 transition-all has-[:checked]:border-amber-400 has-[:checked]:bg-amber-50/40">
                            <input type="radio" name="status" value="draft" {{ old('status', $article->status) === 'draft' ? 'checked' : '' }} class="accent-amber-500">
                            <div>
                                <p class="text-sm font-bold text-slate-700">Simpan sebagai Draf</p>
                                <p class="text-xs text-slate-400">Tidak tampil ke pengguna</p>
                            </div>
                        </label>
                    </div>
                    @if($article->published_at)
                    <p class="text-[10px] text-slate-400 mt-3">Diterbitkan: {{ $article->published_at->format('d M Y, H:i') }}</p>
                    @endif
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <select name="category" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#0d7a70] bg-white text-slate-600">
                        @php $cats = ['Kesehatan Mental', 'Teknik Relaksasi', 'Mindfulness', 'Gaya Hidup Sehat', 'Tips & Trik', 'Informasi Umum']; @endphp
                        @foreach($cats as $cat)
                            <option value="{{ $cat }}" {{ old('category', $article->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit"
                            class="w-full py-3 bg-[#0d7a70] text-white font-bold text-sm rounded-xl hover:bg-[#0a635b] transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.articles.index') }}"
                       class="w-full py-3 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors text-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>
