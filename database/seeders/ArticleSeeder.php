<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user admin
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $contents = [
            // Kategori: Panduan (5 item)
            [
                'title' => 'Panduan Manajemen Stres untuk Mahasiswa Baru',
                'excerpt' => 'Langkah demi langkah menghadapi tekanan perkuliahan di tahun pertama agar tidak kewalahan.',
                'content' => '<p>Transisi dari sekolah menengah ke perguruan tinggi bisa sangat menantang...</p><p>Berikut adalah 5 langkah penting manajemen stres...</p>',
                'category' => 'Panduan',
            ],
            [
                'title' => 'Cara Mengatasi Prokrastinasi Akademik',
                'excerpt' => 'Panduan praktis untuk berhenti menunda tugas dan mulai bekerja dengan lebih produktif.',
                'content' => '<p>Menunda pekerjaan seringkali bukan karena malas, melainkan rasa takut akan kegagalan atau tugas yang terlalu besar...</p>',
                'category' => 'Panduan',
            ],
            [
                'title' => 'Menjaga Keseimbangan Kuliah dan Kehidupan Sosial',
                'excerpt' => 'Tips membagi waktu antara kewajiban akademik, organisasi, dan waktu untuk diri sendiri.',
                'content' => '<p>Penting untuk membuat skala prioritas. Gunakan matriks Eisenhower untuk menentukan mana yang mendesak dan penting...</p>',
                'category' => 'Panduan',
            ],
            [
                'title' => 'Panduan Membangun Rutinitas Tidur yang Sehat',
                'excerpt' => 'Kualitas tidur sangat berpengaruh pada kesehatan mental. Ikuti panduan ini untuk tidur yang lebih nyenyak.',
                'content' => '<p>Kurangi penggunaan gadget 1 jam sebelum tidur dan pastikan suhu kamar dalam kondisi ideal...</p>',
                'category' => 'Panduan',
            ],
            [
                'title' => 'Mengelola Kecemasan Saat Menjelang Ujian',
                'excerpt' => 'Strategi efektif untuk menenangkan pikiran dan meningkatkan fokus saat masa ujian tiba.',
                'content' => '<p>Persiapan yang matang adalah kunci. Jangan lakukan sistem kebut semalam...</p>',
                'category' => 'Panduan',
            ],

            // Kategori: Artikel (5 item)
            [
                'title' => 'Mengenal Perbedaan Sedih Biasa dan Depresi',
                'excerpt' => 'Banyak yang salah mengartikan kesedihan sementara dengan depresi. Mari kenali perbedaannya secara psikologis.',
                'content' => '<p>Kesedihan adalah emosi normal yang dialami manusia ketika menghadapi kejadian buruk, namun depresi adalah gangguan mood...</p>',
                'category' => 'Artikel',
            ],
            [
                'title' => 'Dampak Burnout Akademik Terhadap Prestasi',
                'excerpt' => 'Kelelahan ekstrem akibat beban tugas berlebih bisa menurunkan performa kognitif Anda secara drastis.',
                'content' => '<p>Burnout ditandai dengan kelelahan emosional, depersonalisasi, dan penurunan pencapaian pribadi...</p>',
                'category' => 'Artikel',
            ],
            [
                'title' => 'Pentingnya Berbicara: Mengapa Konseling Itu Perlu',
                'excerpt' => 'Menyimpan masalah sendiri dapat memperburuk kondisi mental. Ini alasan mengapa Anda perlu mencari bantuan profesional.',
                'content' => '<p>Mencari bantuan psikologis bukanlah tanda kelemahan, melainkan langkah berani untuk memulihkan diri...</p>',
                'category' => 'Artikel',
            ],
            [
                'title' => 'Nutrisi dan Kesehatan Mental: Apa Hubungannya?',
                'excerpt' => 'Makanan yang Anda konsumsi berdampak langsung pada produksi hormon bahagia di otak.',
                'content' => '<p>Sekitar 95% serotonin diproduksi di saluran pencernaan. Oleh karena itu, diet sehat sangat berpengaruh...</p>',
                'category' => 'Artikel',
            ],
            [
                'title' => 'Mengapa Perfeksionisme Bisa Menjadi Toksik',
                'excerpt' => 'Standar yang terlalu tinggi seringkali menjadi sumber stres dan kecemasan tiada akhir bagi mahasiswa.',
                'content' => '<p>Belajarlah untuk menerima bahwa "cukup baik" sudah memadai. Perfeksionisme bisa menghambat progres...</p>',
                'category' => 'Artikel',
            ],

            // Kategori: Video (5 item)
            [
                'title' => 'Video: 5 Menit Peregangan di Sela-Sela Mengerjakan Tugas',
                'excerpt' => 'Gerakan ringan yang bisa Anda lakukan di meja belajar untuk melepaskan ketegangan otot leher dan punggung.',
                'content' => '<p>[Tautan Video atau Embed Video]</p><p>Ikuti gerakan ini setiap 2 jam sekali saat Anda duduk lama mengerjakan tugas.</p>',
                'category' => 'Video',
            ],
            [
                'title' => 'Video: Edukasi Singkat Tentang Serangan Panik',
                'excerpt' => 'Memahami apa itu panic attack dan bagaimana cara memberikan pertolongan pertama pada diri sendiri.',
                'content' => '<p>[Tautan Video atau Embed Video]</p><p>Menarik napas dalam-dalam dan melakukan grounding technique sangat disarankan.</p>',
                'category' => 'Video',
            ],
            [
                'title' => 'Video: Journaling untuk Pemula',
                'excerpt' => 'Cara memulai kebiasaan menulis jurnal untuk mengekspresikan emosi negatif yang terpendam.',
                'content' => '<p>[Tautan Video atau Embed Video]</p><p>Tidak ada aturan baku dalam journaling, cukup tuangkan apa yang Anda rasakan.</p>',
                'category' => 'Video',
            ],
            [
                'title' => 'Video: Teknik Pomodoro untuk Fokus Optimal',
                'excerpt' => 'Metode manajemen waktu terbaik untuk mahasiswa yang sering merasa kehilangan fokus belajar.',
                'content' => '<p>[Tautan Video atau Embed Video]</p><p>25 menit fokus penuh, diikuti 5 menit istirahat, dapat mencegah kelelahan otak.</p>',
                'category' => 'Video',
            ],
            [
                'title' => 'Video: Mengubah Pola Pikir Negatif (CBT Dasar)',
                'excerpt' => 'Pengenalan terapi kognitif perilaku untuk mengidentifikasi dan menantang pikiran irasional.',
                'content' => '<p>[Tautan Video atau Embed Video]</p><p>Sadari kapan Anda melakukan overgeneralization atau black-and-white thinking.</p>',
                'category' => 'Video',
            ],

            // Kategori: Audio (5 item)
            [
                'title' => 'Audio: Meditasi Pernapasan 4-7-8 untuk Tidur',
                'excerpt' => 'Audio panduan relaksasi yang menggunakan teknik napas dalam untuk membantu Anda cepat terlelap.',
                'content' => '<p>[Pemutar Audio]</p><p>Tarik napas 4 detik, tahan 7 detik, dan hembuskan perlahan selama 8 detik.</p>',
                'category' => 'Audio',
            ],
            [
                'title' => 'Audio: Afirmasi Pagi untuk Memulai Hari',
                'excerpt' => 'Dengarkan rekaman 3 menit ini sebelum berangkat kuliah untuk menanamkan energi positif.',
                'content' => '<p>[Pemutar Audio]</p><p>Ulangi kata-kata positif untuk membangun kepercayaan diri Anda hari ini.</p>',
                'category' => 'Audio',
            ],
            [
                'title' => 'Audio: Relaksasi Otot Progresif (PMR)',
                'excerpt' => 'Panduan mengencangkan dan mengendurkan otot-otot tubuh untuk mengurangi stres fisik parah.',
                'content' => '<p>[Pemutar Audio]</p><p>Fokuskan pada sensasi ketegangan yang lepas dari tubuh Anda secara bertahap.</p>',
                'category' => 'Audio',
            ],
            [
                'title' => 'Audio: Sesi Mindfulness Singkat Saat Kewalahan',
                'excerpt' => 'Hentikan aktivitas Anda sejenak dan dengarkan audio ini saat merasa cemas dan overthinking.',
                'content' => '<p>[Pemutar Audio]</p><p>Kembalikan kesadaran Anda ke masa sekarang dengan memfokuskan panca indera.</p>',
                'category' => 'Audio',
            ],
            [
                'title' => 'Audio: Lo-Fi Binaural Beats untuk Fokus Belajar',
                'excerpt' => 'Kompilasi frekuensi suara yang didesain untuk merangsang gelombang otak agar lebih konsentrasi.',
                'content' => '<p>[Pemutar Audio]</p><p>Gunakan earphone untuk mendapatkan efek binaural beats secara maksimal saat belajar.</p>',
                'category' => 'Audio',
            ],
        ];

        foreach ($contents as $content) {
            Article::create([
                'author_id' => $admin->id,
                'title' => $content['title'],
                'slug' => Str::slug($content['title'] . '-' . Str::random(5)),
                'excerpt' => $content['excerpt'],
                'content' => $content['content'],
                'category' => $content['category'],
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
