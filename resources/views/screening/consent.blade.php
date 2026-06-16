<x-guest-layout>

    <x-slot name="title">Mulai Assessment | DepreSense</x-slot>

    {{-- ── Alert: Sesi Kadaluarsa ──────────────────────────────────────────── --}}
    @if(session('session_expired'))
    <div class="mb-6 flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="text-sm font-bold">Sesi Berakhir</p>
            <p class="text-xs mt-0.5">Sesi kamu telah berakhir karena melebihi batas waktu <strong>30 menit</strong>. Silakan mulai screening dari awal.</p>
        </div>
    </div>
    @endif

    {{-- ── Alert: Cooldown 14 Hari ─────────────────────────────────────────── --}}
    @if(session('cooldown_active'))
    @php $cd = session('cooldown_active'); @endphp
    <div class="mb-6 flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-2xl text-blue-800">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="text-sm font-bold">Screening Belum Tersedia</p>
            <p class="text-xs mt-0.5 leading-relaxed">
                Kamu telah melakukan screening pada <strong>{{ $cd['last_completed'] }}</strong>.
                BDI-II mengukur kondisi <strong>2 minggu terakhir</strong>, sehingga screening berikutnya
                tersedia pada <strong>{{ $cd['next_allowed_at'] }}</strong>
                ({{ $cd['days_left'] }} hari lagi).
            </p>
        </div>
    </div>
    @endif

    <div class="w-full bg-white">
        </div>

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Informed Consent</h2>
        <p class="text-slate-500 text-sm mt-1 font-medium italic">Persetujuan Penilaian</p>
    </div>

    <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100 text-sm text-slate-600 mb-6 max-h-72 overflow-y-auto custom-scrollbar shadow-inner">
        <p class="mb-4 text-base font-semibold text-[#0d7a70]">Selamat datang di DepreSense.</p>
        
        <p class="mb-4 leading-relaxed text-xs">
            Kuesioner ini dirancang menggunakan instrumen <strong>BDI-II (Beck Depression Inventory-II)</strong> untuk mendeteksi secara dini indikasi depresi. Sistem ini menggunakan <strong>algoritma analisis terstruktur</strong> untuk memproses jawaban Anda.
        </p>

        <ul class="list-disc pl-5 mb-4 space-y-2 text-xs leading-relaxed">
            <li>Kuesioner terdiri dari 21 kelompok pernyataan.</li>
            <li>Pilih satu pernyataan dari setiap kelompok yang paling menggambarkan perasaan Anda dalam <strong>dua minggu terakhir</strong>, termasuk hari ini.</li>
            <li>Jawaban Anda bersifat rahasia. Jika Anda login, data akan disimpan untuk memantau perkembangan Anda. Jika tidak, data hanya bersifat sementara.</li>
            <li>Batas waktu pengerjaan adalah <strong>30 menit</strong>. Sesi yang tidak selesai dalam batas waktu akan dihapus dan harus dimulai ulang.</li>
            <li>Pengguna yang login hanya dapat melakukan screening <strong>1 kali setiap 14 hari</strong>, sesuai periode retrospektif BDI-II.</li>
        </ul>

        <div class="p-4 bg-orange-50 text-orange-800 rounded-2xl border border-orange-100 leading-relaxed text-[11px]">
            <div class="flex gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span><strong>Peringatan:</strong> Hasil dari sistem ini <strong>bukanlah diagnosis medis resmi</strong>. Sangat disarankan untuk berkonsultasi dengan profesional kesehatan mental untuk diagnosis lebih lanjut.</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('screening.consent.store') }}">
        @csrf
        
        <div class="mb-8 flex items-start group cursor-pointer">
            <div class="flex items-center h-6">
                <input id="consent" name="consent" type="checkbox" required 
                    class="w-6 h-6 text-[#00aba9] bg-white border-slate-200 rounded-lg focus:ring-[#00aba9] transition-all cursor-pointer">
            </div>
            <label for="consent" class="ml-3 text-xs font-medium text-slate-500 leading-relaxed cursor-pointer group-hover:text-slate-700">
                Saya telah membaca, memahami, dan menyetujui ketentuan di atas. Saya bersedia mengikuti penilaian ini secara jujur.
            </label>
        </div>
        
        @error('consent')
            <p class="text-red-500 text-xs mb-4 px-2">{{ $message }}</p>
        @enderror

        <div class="flex gap-3">
            <a href="{{ auth()->check() ? (auth()->user()->role->value === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : route('home') }}" 
               class="flex-1 px-4 py-4 text-center text-slate-500 bg-slate-50 hover:bg-slate-100 rounded-2xl font-bold transition-all border border-slate-100">
                Batal
            </a>
            <button type="submit" 
                class="flex-[2] px-4 py-4 text-center text-white bg-[#00aba9] hover:bg-[#0d7a70] rounded-2xl font-bold transition-all shadow-md shadow-teal-100 active:scale-[0.98]">
                Setuju & Mulai
            </button>
        </div>
    </form>

    <style>
        /* Styling Scrollbar agar lebih tipis dan estetik */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</x-guest-layout>