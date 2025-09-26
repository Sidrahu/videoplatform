<div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-blue-50 py-12 px-6">
    <div class="max-w-7xl mx-auto space-y-12">

        @if(auth()->check() && auth()->user()->hasRole('admin'))

        <!-- 🧠 Admin Heading -->
        <header class="mb-6">
            <h2 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">📊 Admin Dashboard</h2>
            <p class="text-sm text-gray-500">Real-time insights for managing platform activity.</p>
        </header>

        <!-- ✨ Summary Cards -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 👥 Total Users -->
            <div class="bg-white p-6 rounded-3xl shadow-xl border border-blue-100 hover:shadow-2xl transition">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 p-4 rounded-full text-blue-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Users</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>

            <!-- 📚 Total Courses -->
            <div class="bg-white p-6 rounded-3xl shadow-xl border border-green-100 hover:shadow-2xl transition">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 p-4 rounded-full text-green-600">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Courses</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalCourses }}</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- 📝 Recent Quiz Results -->
        <section class="bg-white p-6 rounded-3xl shadow-xl border border-purple-100">
            <h2 class="text-2xl font-bold text-purple-700 mb-6 flex items-center gap-2">
                <i class="fas fa-clipboard-check text-purple-500"></i>
                Recent Quiz Results
            </h2>
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Quiz</th>
                            <th class="px-4 py-3">Score</th>
                            <th class="px-4 py-3">Percentage</th>
                            <th class="px-4 py-3">Passed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($quizResults as $result)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $result->user->name }}</td>
                                <td class="px-4 py-3">{{ $result->quiz->title }}</td>
                                <td class="px-4 py-3">{{ $result->score }}</td>
                                <td class="px-4 py-3">{{ number_format(($result->score / $result->quiz->questions->count()) * 100, 2) }}%</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ ($result->score / $result->quiz->questions->count()) * 100 >= 70 
                                            ? 'bg-green-100 text-green-700' 
                                            : 'bg-red-100 text-red-600' }}">
                                        {{ ($result->score / $result->quiz->questions->count()) * 100 >= 70 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">No quiz results available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 🎓 Recent Enrollments -->
        <section class="bg-white p-6 rounded-3xl shadow-xl border border-indigo-100">
            <h2 class="text-2xl font-bold text-indigo-700 mb-6 flex items-center gap-2">
                <i class="fas fa-user-graduate text-indigo-500"></i>
                Recent Enrollments
            </h2>
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Course</th>
                            <th class="px-4 py-3">Enrolled At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $enrollment->user->name }}</td>
                                <td class="px-4 py-3">{{ $enrollment->course->title }}</td>
                                <td class="px-4 py-3">{{ $enrollment->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-400">No enrollments yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        @endif
    </div>
</div>
