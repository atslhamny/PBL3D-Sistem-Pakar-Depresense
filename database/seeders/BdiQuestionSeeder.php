<?php

namespace Database\Seeders;

use App\Models\BdiQuestion;
use App\Enums\QuestionCategory;
use App\Enums\QuestionSubCategory;
use Illuminate\Database\Seeder;

class BdiQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            1 => [
                'question_text'  => 'Bagaimana perasaan umum yang kamu rasakan dalam dua minggu terakhir ini?',
                'answer_options' => [
                    'Saya merasa biasa saja. Tidak ada rasa sedih yang mengganggu.',
                    'Saya kadang-kadang merasa sedih atau murung.',
                    'Saya hampir setiap saat merasa sedih tanpa tahu alasan yang jelas.',
                    'Saya terus-menerus merasa sangat sedih hingga terasa menyiksa.',
                ],
            ],
            2 => [
                'question_text'  => 'Bagaimana pandanganmu tentang masa depan dalam dua minggu terakhir ini?',
                'answer_options' => [
                    'Saya masih bisa melihat kemungkinan-kemungkinan baik di masa depan.',
                    'Saya merasa kurang yakin dengan masa depan saya dibanding biasanya.',
                    'Saya sulit membayangkan ada hal baik yang akan terjadi.',
                    'Saya yakin masa depan saya akan buruk.',
                ],
            ],
            3 => [
                'question_text'  => 'Bagaimana kamu menilai pengalaman hidupmu selama ini, terutama tentang keberhasilan dan kegagalan?',
                'answer_options' => [
                    'Saya tidak merasa bahwa saya lebih banyak gagal dari orang lain.',
                    'Saya merasa sudah lebih banyak mengalami kegagalan dibanding orang lain.',
                    'Ketika saya merenungkan hidup saya, yang dominan adalah kegagalan.',
                    'Saya merasa hidup saya adalah rangkaian kegagalan total.',
                ],
            ],
            4 => [
                'question_text'  => 'Apakah kamu masih bisa menikmati hal-hal yang sebelumnya kamu sukai atau anggap menyenangkan?',
                'answer_options' => [
                    'Saya masih bisa menikmati hal-hal yang saya sukai seperti biasanya.',
                    'Saya merasa kurang bisa menikmati hal-hal yang biasanya saya suka.',
                    'Hampir semua hal yang dulu saya nikmati kini terasa hambar.',
                    'Tidak ada satupun hal yang bisa membuat saya merasa senang.',
                ],
            ],
            5 => [
                'question_text'  => 'Seberapa sering kamu merasa bersalah atas hal-hal yang telah kamu lakukan atau tidak kamu lakukan?',
                'answer_options' => [
                    'Saya tidak merasa bersalah lebih dari yang wajar.',
                    'Saya lebih sering merasa bersalah dari biasanya atas hal-hal kecil.',
                    'Saya hampir selalu merasa bersalah.',
                    'Saya merasa bersalah terus-menerus atas hampir semua hal.',
                ],
            ],
            6 => [
                'question_text'  => 'Apakah kamu merasa bahwa hal-hal buruk yang terjadi kepadamu adalah sebuah bentuk hukuman?',
                'answer_options' => [
                    'Saya tidak merasa sedang dihukum atas apapun.',
                    'Terkadang saya berpikir mungkin kejadian buruk ini adalah semacam ganjaran.',
                    'Saya merasa bahwa saya memang layak mendapat hukuman.',
                    'Saya yakin saya sedang dihukum.',
                ],
            ],
            7 => [
                'question_text'  => 'Bagaimana perasaanmu terhadap dirimu sendiri belakangan ini?',
                'answer_options' => [
                    'Saya merasa baik-baik saja dengan diri saya.',
                    'Saya merasa kurang puas dengan diri saya belakangan ini.',
                    'Saya tidak menyukai diri saya sendiri.',
                    'Saya membenci diri saya sendiri.',
                ],
            ],
            8 => [
                'question_text'  => 'Apakah kamu cenderung menyalahkan dirimu sendiri ketika ada hal yang tidak berjalan dengan baik?',
                'answer_options' => [
                    'Saya tidak lebih menyalahkan diri sendiri dari biasanya.',
                    'Saya lebih sering mengkritik diri sendiri dari biasanya.',
                    'Saya hampir selalu menyalahkan diri sendiri atas berbagai masalah.',
                    'Saya merasa bertanggung jawab atas semua hal buruk yang terjadi.',
                ],
            ],
            9 => [
                'question_text'  => 'Apakah kamu pernah memiliki pikiran untuk menyakiti diri sendiri atau tidak ingin hidup lagi?',
                'answer_options' => [
                    'Saya tidak memiliki pikiran untuk menyakiti diri sendiri.',
                    'Saya pernah berharap bisa tidur dan tidak bangun lagi.',
                    'Pikiran untuk mengakhiri hidup cukup sering muncul.',
                    'Saya memiliki pikiran kuat untuk bunuh diri.',
                ],
            ],
            10 => [
                'question_text'  => 'Seberapa sering kamu menangis dalam dua minggu terakhir ini?',
                'answer_options' => [
                    'Saya tidak lebih sering menangis dari biasanya.',
                    'Saya lebih mudah menangis belakangan ini.',
                    'Saya hampir selalu menangis untuk berbagai hal.',
                    'Saya tidak bisa berhenti menangis meskipun sudah berusaha.',
                ],
            ],
            11 => [
                'question_text'  => 'Apakah kamu merasa lebih gelisah atau tidak bisa tenang belakangan ini?',
                'answer_options' => [
                    'Saya tidak merasa lebih gelisah dari biasanya.',
                    'Saya merasa lebih gelisah dan resah dari biasanya.',
                    'Saya merasa sangat gelisah dan tegang.',
                    'Saya tidak bisa duduk atau berdiam diri sama sekali.',
                ],
            ],
            12 => [
                'question_text'  => 'Apakah kamu masih tertarik untuk melakukan berbagai aktivitas atau berinteraksi dengan orang lain?',
                'answer_options' => [
                    'Saya masih tertarik pada berbagai aktivitas seperti biasanya.',
                    'Saya merasa kurang bersemangat dan kurang tertarik pada banyak hal.',
                    'Saya telah kehilangan sebagian besar minat saya.',
                    'Saya sama sekali tidak tertarik pada apapun atau siapapun.',
                ],
            ],
            13 => [
                'question_text'  => 'Seberapa mudah kamu membuat keputusan dalam dua minggu terakhir?',
                'answer_options' => [
                    'Saya masih bisa mengambil keputusan seperti biasanya.',
                    'Saya merasa lebih sulit mengambil keputusan dari biasanya.',
                    'Mengambil keputusan terasa sangat berat.',
                    'Saya hampir tidak bisa membuat keputusan apapun.',
                ],
            ],
            14 => [
                'question_text'  => 'Apakah kamu merasa dirimu berharga atau memiliki nilai sebagai seorang manusia?',
                'answer_options' => [
                    'Saya tidak merasa diri saya tidak berharga.',
                    'Saya merasa kurang berharga dari sebelumnya.',
                    'Saya merasa diri saya tidak berharga.',
                    'Saya benar-benar merasa tidak berharga dan tidak berguna.',
                ],
            ],
            15 => [
                'question_text'  => 'Bagaimana tingkat energimu untuk menjalani aktivitas sehari-hari dalam dua minggu terakhir?',
                'answer_options' => [
                    'Energi saya masih cukup untuk menjalani hari.',
                    'Saya merasa lebih mudah lelah dari biasanya.',
                    'Energi saya terasa sangat terbatas.',
                    'Saya hampir tidak memiliki energi sama sekali.',
                ],
            ],
            16 => [
                'question_text'  => 'Apakah ada perubahan pada pola tidurmu dalam dua minggu terakhir ini?',
                'answer_options' => [
                    'Pola tidur saya masih normal seperti biasanya.',
                    'Pola tidur saya sedikit berubah (tidur lebih lama/sebentar).',
                    'Tidur saya cukup terganggu (sering insomnia/berlebihan).',
                    'Pola tidur saya sangat kacau.',
                ],
            ],
            17 => [
                'question_text'  => 'Apakah kamu lebih mudah merasa kesal, marah, atau terganggu?',
                'answer_options' => [
                    'Saya tidak lebih mudah marah dari biasanya.',
                    'Saya lebih gampang kesal dari biasanya.',
                    'Saya merasa sangat mudah marah hampir setiap hari.',
                    'Saya terus-menerus merasa marah dan mudah tersulut.',
                ],
            ],
            18 => [
                'question_text'  => 'Apakah ada perubahan pada nafsu makan atau kebiasaan makanmu?',
                'answer_options' => [
                    'Nafsu makan saya masih normal.',
                    'Nafsu makan saya sedikit berkurang atau bertambah.',
                    'Nafsu makan saya berubah cukup signifikan.',
                    'Saya hampir tidak nafsu makan atau makan berlebihan tanpa kontrol.',
                ],
            ],
            19 => [
                'question_text'  => 'Seberapa mudah kamu berkonsentrasi atau memusatkan perhatian?',
                'answer_options' => [
                    'Konsentrasi saya masih baik seperti biasanya.',
                    'Saya merasa sulit untuk berkonsentrasi lebih dari beberapa menit.',
                    'Sangat sulit bagi saya untuk fokus pada apapun.',
                    'Saya tidak bisa berkonsentrasi sama sekali.',
                ],
            ],
            20 => [
                'question_text'  => 'Seberapa lelah yang kamu rasakan dalam menjalani aktivitas sehari-hari?',
                'answer_options' => [
                    'Saya tidak merasa lebih lelah dari biasanya.',
                    'Saya merasa lebih cepat lelah dari biasanya.',
                    'Kelelahan saya cukup parah hingga harus membatalkan kegiatan.',
                    'Saya kelelahan luar biasa yang hampir melumpuhkan.',
                ],
            ],
            21 => [
                'question_text'  => 'Apakah ada perubahan pada minat atau dorongan seksualmu?',
                'answer_options' => [
                    'Tidak ada perubahan berarti pada minat seksual saya.',
                    'Minat seksual saya terasa sedikit berkurang.',
                    'Minat seksual saya berkurang cukup jauh.',
                    'Saya kehilangan minat seksual sepenuhnya.',
                ],
            ],
        ];

        foreach ($questions as $itemNumber => $data) {
            $isCognitive = $itemNumber <= 13;

            BdiQuestion::updateOrCreate(
                ['item_number' => $itemNumber],
                [
                    'question_text'  => $data['question_text'],
                    'answer_options' => $data['answer_options'],
                    'category'       => $isCognitive
                        ? QuestionCategory::KognitifAfektif->value
                        : QuestionCategory::Somatik->value,
                    'sub_category'   => $isCognitive
                        ? QuestionSubCategory::Kognitif->value
                        : QuestionSubCategory::Fisik->value,
                    'is_safety_item' => ($itemNumber === 9),
                    'safety_threshold' => 2,
                    'sort_order'     => $itemNumber,
                    'is_locked'      => true,
                ]
            );
        }
    }
}
