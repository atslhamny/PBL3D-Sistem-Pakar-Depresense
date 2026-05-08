<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Assessment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Grafik Perkembangan (BDI-II & Fuzzy)</h3>
                    <div class="relative h-72 w-full">
                        <canvas id="historyChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Detail Riwayat</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                    <th class="p-4 border-b border-gray-200 dark:border-gray-600">Tanggal</th>
                                    <th class="p-4 border-b border-gray-200 dark:border-gray-600 text-center">Skor Total</th>
                                    <th class="p-4 border-b border-gray-200 dark:border-gray-600 text-center">Skor Kognitif</th>
                                    <th class="p-4 border-b border-gray-200 dark:border-gray-600 text-center">Skor Somatik</th>
                                    <th class="p-4 border-b border-gray-200 dark:border-gray-600 text-center">Nilai Fuzzy</th>
                                    <th class="p-4 border-b border-gray-200 dark:border-gray-600">Indikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $session)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="p-4 border-b border-gray-100 dark:border-gray-700 font-medium">{{ $session->completed_at->format('d M Y, H:i') }}</td>
                                        <td class="p-4 border-b border-gray-100 dark:border-gray-700 text-center font-bold">{{ $session->score_total }}</td>
                                        <td class="p-4 border-b border-gray-100 dark:border-gray-700 text-center">{{ $session->score_cognitive_affective }}</td>
                                        <td class="p-4 border-b border-gray-100 dark:border-gray-700 text-center">{{ $session->score_somatic }}</td>
                                        <td class="p-4 border-b border-gray-100 dark:border-gray-700 text-center text-indigo-600 dark:text-indigo-400 font-semibold">{{ $session->fuzzy_centroid_value }}</td>
                                        <td class="p-4 border-b border-gray-100 dark:border-gray-700 capitalize">
                                            @php
                                                $color = match($session->depression_level->value) {
                                                    'minimal' => 'text-green-600 bg-green-50 dark:bg-green-900/20 dark:text-green-400',
                                                    'ringan' => 'text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 dark:text-yellow-400',
                                                    'sedang' => 'text-orange-600 bg-orange-50 dark:bg-orange-900/20 dark:text-orange-400',
                                                    'berat' => 'text-red-600 bg-red-50 dark:bg-red-900/20 dark:text-red-400',
                                                };
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                                {{ $session->depression_level->value }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada riwayat assessment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('historyChart');
            if(ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [
                            {
                                label: 'Skor BDI-II',
                                data: {!! json_encode($chartData['scores']) !!},
                                borderColor: 'rgb(99, 102, 241)',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Nilai Fuzzy (0-100)',
                                data: {!! json_encode($chartData['fuzzy_values']) !!},
                                borderColor: 'rgb(168, 85, 247)',
                                backgroundColor: 'transparent',
                                borderDash: [5, 5],
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
