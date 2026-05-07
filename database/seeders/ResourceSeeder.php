<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil id admin yang sudah dibuat di AdminUserSeeder
        $adminId = DB::table('users')
                     ->where('email', 'admin@sistempakar.id')
                     ->value('id');

        $resources = [
            // Untuk level minimal
            ['Mengenal Kesehatan Mental Mahasiswa',    'artikel', 'minimal', 1],
            ['Tips Menjaga Keseimbangan Akademik',     'artikel', 'minimal', 2],
            ['Musik Relaksasi untuk Produktivitas',    'musik',   'minimal', 3],

            // Untuk level ringan
            ['Strategi Koping Stres Sehari-hari',      'artikel', 'ringan',  1],
            ['Meditasi 10 Menit untuk Mahasiswa',      'video',   'ringan',  2],
            ['Podcast: Cerita dari Rantau',            'podcast', 'ringan',  3],

            // Untuk level sedang
            ['Kapan Harus Ke Psikolog?',               'artikel', 'sedang',  1],
            ['Panduan Mencari Bantuan Profesional',    'artikel', 'sedang',  2],
            ['Latihan Pernapasan & Grounding',         'video',   'sedang',  3],

            // Untuk level berat
            ['Hotline Kesehatan Mental 119 ext 8',     'artikel', 'berat',   1],
            ['Langkah Darurat: Menghubungi Konselor',  'artikel', 'berat',   2],
            ['Into The Light Indonesia — Komunitas',   'artikel', 'berat',   3],

            // Untuk semua level
            ['Jurnal Harian untuk Kesehatan Mental',   'artikel', 'semua',   1],
        ];

        foreach ($resources as [$title, $type, $level, $priority]) {
            DB::table('resources')->insert([
                'id'           => Str::uuid(),
                'title'        => $title,
                'description'  => 'Konten ini dapat membantu kamu dalam mengelola kesehatan mental.',
                'content_type' => $type,
                'url'          => null,
                'thumbnail_url'=> null,
                'target_level' => $level,
                'priority'     => $priority,
                'is_active'    => true,
                'created_by'   => $adminId,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}