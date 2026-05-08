<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Informed Consent</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Persetujuan Penilaian</p>
    </div>

    <div class="bg-white dark:bg-slate-800/50 p-6 rounded-2xl border border-slate-100 dark:border-slate-700 text-sm text-slate-600 dark:text-slate-300 mb-6 max-h-64 overflow-y-auto">
        <p class="mb-4">Selamat datang di <strong>DepreSense</strong>.</p>
        <p class="mb-4">Kuesioner ini dirancang menggunakan instrumen <strong>BDI-II (Beck Depression Inventory-II)</strong> untuk mendeteksi secara dini indikasi depresi. Sistem ini menggunakan kecerdasan buatan berbasis <strong>Fuzzy Mamdani</strong> untuk menganalisis jawaban Anda.</p>
        <ul class="list-disc pl-5 mb-4 space-y-2">
            <li>Kuesioner terdiri dari 21 kelompok pernyataan.</li>
            <li>Pilih satu pernyataan dari setiap kelompok yang paling menggambarkan perasaan Anda dalam <strong>dua minggu terakhir</strong>, termasuk hari ini.</li>
            <li>Jawaban Anda bersifat rahasia. Jika Anda login, data akan disimpan untuk memantau perkembangan Anda. Jika tidak, data hanya bersifat sementara (guest session).</li>
        </ul>
        <div class="p-4 bg-orange-50 dark:bg-orange-900/20 text-orange-800 dark:text-orange-200 rounded-xl border border-orange-200 dark:border-orange-800/30">
            <strong>Peringatan:</strong> Hasil dari sistem ini <strong>bukanlah diagnosis medis resmi</strong>. Jika hasil menunjukkan indikasi yang perlu diwaspadai, sangat disarankan untuk berkonsultasi dengan profesional kesehatan mental.
        </div>
    </div>

    <form method="POST" action="{{ route('screening.consent.store') }}">
        @csrf
        <div class="mb-6 flex items-start">
            <div class="flex items-center h-5">
                <input id="consent" name="consent" type="checkbox" required class="w-5 h-5 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600 transition-colors">
            </div>
            <label for="consent" class="ml-3 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                Saya telah membaca, memahami, dan menyetujui ketentuan di atas. Saya bersedia mengikuti penilaian ini secara jujur.
            </label>
        </div>
        
        @error('consent')
            <p class="text-red-500 text-xs mb-4">{{ $message }}</p>
        @enderror

        <div class="flex gap-4">
            <a href="{{ route('home') }}" class="w-1/3 px-4 py-3 text-center text-slate-700 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600 rounded-xl font-medium transition-colors">
                Batal
            </a>
            <button type="submit" class="w-2/3 px-4 py-3 text-center text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl font-medium transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:scale-[1.02]">
                Setuju & Mulai
            </button>
        </div>
    </form>
</x-guest-layout>
