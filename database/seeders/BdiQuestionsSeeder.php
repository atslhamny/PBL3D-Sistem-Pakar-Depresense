<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BdiQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'item_number'      => 1,
                'question_text'    => 'Bagaimana perasaan umum yang kamu rasakan dalam dua minggu terakhir ini?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Emosi',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 1,
            ],
            [
                'item_number'      => 2,
                'question_text'    => 'Bagaimana pandanganmu tentang masa depan dalam dua minggu terakhir ini?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Kognitif',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 2,
            ],
            [
                'item_number'      => 3,
                'question_text'    => 'Bagaimana kamu menilai pengalaman hidupmu selama ini, terutama tentang keberhasilan dan kegagalan?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Kognitif',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 3,
            ],
            [
                'item_number'      => 4,
                'question_text'    => 'Apakah kamu masih bisa menikmati hal-hal yang sebelumnya kamu sukai atau anggap menyenangkan?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Emosi',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 4,
            ],
            [
                'item_number'      => 5,
                'question_text'    => 'Seberapa sering kamu merasa bersalah atas hal-hal yang telah kamu lakukan atau tidak kamu lakukan?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Emosi',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 5,
            ],
            [
                'item_number'      => 6,
                'question_text'    => 'Apakah kamu merasa bahwa hal-hal buruk yang terjadi kepadamu adalah sebuah bentuk hukuman?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Kognitif',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 6,
            ],
            [
                'item_number'      => 7,
                'question_text'    => 'Bagaimana perasaanmu terhadap dirimu sendiri belakangan ini?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Emosi',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 7,
            ],
            [
                'item_number'      => 8,
                'question_text'    => 'Apakah kamu cenderung menyalahkan dirimu sendiri ketika ada hal yang tidak berjalan dengan baik?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Kognitif',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 8,
            ],
            [
                'item_number'      => 9,
                'question_text'    => 'Apakah kamu pernah memiliki pikiran untuk menyakiti diri sendiri atau tidak ingin hidup lagi?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Kognitif',
                'is_safety_item'   => true,   // ⚠ SAFETY ITEM
                'safety_threshold' => 2,       // protokol darurat jika >= 2
                'sort_order'       => 9,
            ],
            [
                'item_number'      => 10,
                'question_text'    => 'Seberapa sering kamu menangis dalam dua minggu terakhir ini?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Emosi',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 10,
            ],
            [
                'item_number'      => 11,
                'question_text'    => 'Apakah kamu merasa lebih gelisah atau tidak bisa tenang belakangan ini?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Emosi',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 11,
            ],
            [
                'item_number'      => 12,
                'question_text'    => 'Apakah kamu masih tertarik untuk melakukan berbagai aktivitas atau berinteraksi dengan orang lain?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Emosi',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 12,
            ],
            [
                'item_number'      => 13,
                'question_text'    => 'Seberapa mudah kamu membuat keputusan dalam dua minggu terakhir, baik untuk hal besar maupun hal kecil?',
                'category'         => 'kognitif_afektif',
                'sub_category'     => 'Kognitif',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 13,
            ],
            [
                'item_number'      => 14,
                'question_text'    => 'Apakah kamu merasa dirimu berharga atau memiliki nilai sebagai seorang manusia?',
                'category'         => 'somatik',
                'sub_category'     => 'Kognitif',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 14,
            ],
            [
                'item_number'      => 15,
                'question_text'    => 'Bagaimana tingkat energimu untuk menjalani aktivitas sehari-hari dalam dua minggu terakhir?',
                'category'         => 'somatik',
                'sub_category'     => 'Fisik',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 15,
            ],
            [
                'item_number'      => 16,
                'question_text'    => 'Apakah ada perubahan pada pola tidurmu dalam dua minggu terakhir ini?',
                'category'         => 'somatik',
                'sub_category'     => 'Fisik',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 16,
            ],
            [
                'item_number'      => 17,
                'question_text'    => 'Apakah kamu lebih mudah merasa kesal, marah, atau terganggu oleh hal-hal di sekitarmu belakangan ini?',
                'category'         => 'somatik',
                'sub_category'     => 'Emosi',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 17,
            ],
            [
                'item_number'      => 18,
                'question_text'    => 'Apakah ada perubahan pada nafsu makan atau kebiasaan makanmu dalam dua minggu terakhir?',
                'category'         => 'somatik',
                'sub_category'     => 'Fisik',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 18,
            ],
            [
                'item_number'      => 19,
                'question_text'    => 'Seberapa mudah kamu berkonsentrasi atau memusatkan perhatian pada suatu pekerjaan atau bacaan belakangan ini?',
                'category'         => 'somatik',
                'sub_category'     => 'Kognitif',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 19,
            ],
            [
                'item_number'      => 20,
                'question_text'    => 'Seberapa lelah yang kamu rasakan dalam menjalani aktivitas sehari-hari dalam dua minggu terakhir?',
                'category'         => 'somatik',
                'sub_category'     => 'Fisik',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 20,
            ],
            [
                'item_number'      => 21,
                'question_text'    => 'Apakah ada perubahan pada minat atau dorongan seksualmu dibandingkan sebelumnya?',
                'category'         => 'somatik',
                'sub_category'     => 'Fisik',
                'is_safety_item'   => false,
                'safety_threshold' => null,
                'sort_order'       => 21,
            ],
        ];

        foreach ($questions as $q) {
            DB::table('bdi_questions')->insert([
                'id'               => Str::uuid(),
                'item_number'      => $q['item_number'],
                'question_text'    => $q['question_text'],
                'category'         => $q['category'],
                'sub_category'     => $q['sub_category'],
                'is_safety_item'   => $q['is_safety_item'],
                'safety_threshold' => $q['safety_threshold'],
                'sort_order'       => $q['sort_order'],
                'is_locked'        => false,
                'version'          => 1,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}