<?php

namespace App\Services;

use App\Enums\DepressionLevel;

class RecommendationService
{
    public function getRecommendations(DepressionLevel $level): array
    {
        return match ($level) {
            DepressionLevel::Minimal => [
                'Jaga pola tidur dan makan yang teratur.',
                'Lakukan aktivitas fisik ringan secara rutin.',
                'Tetap terhubung dengan teman dan keluarga.'
            ],
            DepressionLevel::Ringan => [
                'Pertimbangkan untuk mengikuti kegiatan relaksasi atau mindfulness.',
                'Bicarakan perasaan Anda dengan seseorang yang dipercaya.',
                'Kurangi konsumsi kafein dan hindari alkohol.'
            ],
            DepressionLevel::Sedang => [
                'Sangat disarankan untuk berkonsultasi dengan konselor kampus atau psikolog.',
                'Bergabunglah dengan kelompok dukungan sebaya.',
                'Jangan ragu untuk meminta bantuan akademis jika merasa kewalahan.'
            ],
            DepressionLevel::Berat => [
                'Segera hubungi profesional kesehatan mental (psikiater/psikolog).',
                'Gunakan layanan hotline krisis jika Anda merasa tidak aman.',
                'Jangan mengisolasi diri, beri tahu orang terdekat tentang kondisi Anda.'
            ],
        };
    }
}
