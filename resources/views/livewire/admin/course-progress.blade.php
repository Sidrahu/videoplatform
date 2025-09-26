<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19V6m4 13V6M7 19V6" />
        </svg>
        Course Progress – <span class="text-blue-600">{{ $course->title }}</span>
    </h1>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-tr from-blue-100 to-blue-300 text-blue-900 rounded-2xl shadow p-5">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 10l4.553 2.276A1 1 0 0120 13.118v.764a1 1 0 01-.447.842L15 17M4 6h16M4 10h16M4 14h8" />
                </svg>
                <h3 class="text-sm font-semibold">Total Videos</h3>
            </div>
            <p class="text-3xl font-bold mt-2">{{ $totalVideos }}</p>
        </div>

        <div class="bg-gradient-to-tr from-green-100 to-green-300 text-green-900 rounded-2xl shadow p-5">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 17a1 1 0 01-1-1v-4l-3-3m7 0h5m0 0v5m0-5L10 21" />
                </svg>
                <h3 class="text-sm font-semibold">Avg Progress</h3>
            </div>
            <p class="text-3xl font-bold mt-2">{{ $avgCourseProgress }}%</p>
        </div>

        <div class="bg-gradient-to-tr from-purple-100 to-purple-300 text-purple-900 rounded-2xl shadow p-5">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v12a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-sm font-semibold">Completion Rate</h3>
            </div>
            <p class="text-3xl font-bold mt-2">{{ $completionRate }}%</p>
        </div>
    </div>

    {{-- Student Progress Table --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full min-w-[700px] text-left text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A4 4 0 017 17h10a4 4 0 011.879.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Student
                        </div>
                    </th>
                    <th class="px-4 py-3">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 12H8m8 0a4 4 0 10-8 0 4 4 0 008 0zM12 16v2m0 0h-2m2 0h2" />
                            </svg>
                            Email
                        </div>
                    </th>
                    <th class="px-4 py-3">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3v18h18M9 17V9M15 17V5" />
                            </svg>
                            Progress
                        </div>
                    </th>
                    <th class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10l4.553 2.276A1 1 0 0120 13.118v.764a1 1 0 01-.447.842L15 17M4 6h16M4 10h16M4 14h8" />
                            </svg>
                            Watched
                        </div>
                    </th>
                    <th class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Status
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($students as $s)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $s['name'] }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s['email'] }}</td>
                        <td class="px-4 py-3">
                            <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full rounded-full transition-all duration-500"
                                    style="width: {{ $s['avg'] }}%;"></div>
                            </div>
                            <small class="text-gray-600">{{ $s['avg'] }}%</small>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700">
                            {{ $s['watched'] }}/{{ $s['total'] }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($s['completed'])
                                <span class="inline-block bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full">
                                    Completed
                                </span>
                            @else
                                <span class="inline-block bg-yellow-500 text-white text-xs font-medium px-3 py-1 rounded-full">
                                    In Progress
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">No student progress yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
