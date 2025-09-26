<div class="min-h-screen bg-gradient-to-br from-white via-blue-50 to-blue-100 py-12 px-6">
    <div class="max-w-7xl mx-auto space-y-16">

        <!-- 🔷 Header -->
        <header class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-blue-200 p-3 rounded-full shadow">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M3 3h18M3 12h18M3 21h18" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Analytics Dashboard</h1>
                    <p class="text-sm text-gray-500 mt-1">Visual insights into student activity and course performance</p>
                </div>
            </div>
        </header>

        <!-- 📊 Chart Grid -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-10">

            <!-- 👨‍🎓 Top Students Chart -->
            <div class="bg-white rounded-3xl shadow-xl border border-blue-100 p-8">
                <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M5 3v4M19 3v4M3 9h18M4 9v11a1 1 0 001 1h14a1 1 0 001-1V9" />
                    </svg>
                    Top Students by Progress
                </h2>
                <canvas id="studentsChart" height="300"></canvas>
            </div>

            <!-- 📘 Course Engagement Chart -->
            <div class="bg-white rounded-3xl shadow-xl border border-green-100 p-8">
                <h2 class="text-2xl font-bold text-green-700 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Course Engagement Overview
                </h2>
                <canvas id="engagementChart" height="300"></canvas>
            </div>

            <!-- 🧪 Quiz Performance -->
            <div class="bg-white rounded-3xl shadow-xl border border-purple-100 p-8 md:col-span-2">
                <h2 class="text-2xl font-bold text-purple-700 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                    Average Quiz Scores by Course
                </h2>

                <canvas id="quizChart" height="100"></canvas>

                <!-- 📋 Quiz Table -->
                <div class="mt-10">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Average Score Table</h3>

                    @if(!empty($quizData['labels']) && !empty($quizData['data']))
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg shadow border border-gray-200">
                                <thead class="bg-purple-100 text-purple-800 text-left">
                                    <tr>
                                        <th class="py-3 px-6">Course</th>
                                        <th class="py-3 px-6">Average Score (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quizData['labels'] as $index => $course)
                                        <tr class="border-t">
                                            <td class="py-3 px-6">{{ $course }}</td>
                                            <td class="py-3 px-6 font-medium text-gray-700">{{ $quizData['data'][$index] }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No quiz data available.</p>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <!-- 🎨 Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- 📈 Chart Scripts -->
    <script>
        const studentCtx = document.getElementById('studentsChart').getContext('2d');
        const engagementCtx = document.getElementById('engagementChart').getContext('2d');
        const quizCtx = document.getElementById('quizChart').getContext('2d');

        new Chart(studentCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($studentsChartData['labels']) !!},
                datasets: [{
                    label: 'Progress Count',
                    data: {!! json_encode($studentsChartData['data']) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        new Chart(engagementCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($engagementData['labels']) !!},
                datasets: [{
                    label: 'Engagement',
                    data: {!! json_encode($engagementData['data']) !!},
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        new Chart(quizCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($quizData['labels'] ?? ['Course A', 'Course B']) !!},
                datasets: [{
                    label: 'Average Quiz Score (%)',
                    data: {!! json_encode($quizData['data'] ?? [85, 72]) !!},
                    backgroundColor: 'rgba(168, 85, 247, 0.2)',
                    borderColor: 'rgba(168, 85, 247, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgba(168, 85, 247, 1)',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</div>
