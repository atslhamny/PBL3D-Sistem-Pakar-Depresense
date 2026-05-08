<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-indigo-500">
                    <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Pengguna</div>
                    <div class="text-3xl font-black text-gray-800 dark:text-white">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-emerald-500">
                    <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Assessment</div>
                    <div class="text-3xl font-black text-gray-800 dark:text-white">{{ $stats['total_screenings'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-red-500">
                    <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Kasus Emergency</div>
                    <div class="text-3xl font-black text-gray-800 dark:text-white">{{ $stats['emergency_cases'] }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Links ... -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-4">Akses Cepat</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.questions.index') }}" class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-100 dark:border-gray-600">
                                <span class="block font-semibold">Manajemen Soal</span>
                            </a>
                            <a href="{{ route('admin.fuzzy-rules.index') }}" class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-100 dark:border-gray-600">
                                <span class="block font-semibold">Aturan Fuzzy</span>
                            </a>
                            <a href="{{ route('admin.audit-logs.index') }}" class="col-span-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-100 dark:border-gray-600">
                                <span class="block font-semibold">Audit Logs</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col h-full">
                        <h3 class="text-lg font-bold mb-4">Distribusi Indikasi</h3>
                        <div class="relative flex-grow min-h-[200px]">
                            <canvas id="distributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('distributionChart');
            if(ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [{
                            data: {!! json_encode($chartData['data']) !!},
                            backgroundColor: [
                                '#10b981', // emerald-500
                                '#f59e0b', // amber-500
                                '#f97316', // orange-500
                                '#ef4444', // red-500
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
