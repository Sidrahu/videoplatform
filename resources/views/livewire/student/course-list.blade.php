<div class="p-8 max-w-6xl mx-auto">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-8 flex items-center gap-3">
        <!-- Book Open Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m8-6H4" />
        </svg>
        <span>My Courses</span>
    </h2>

    @if(count($courses) > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($courses as $course)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate">{{ $course->title }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ $course->description }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('student.course.show', $course->id) }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-all">
                            View Course
                            <!-- Arrow Right Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl border border-yellow-200 shadow-sm flex items-center gap-2">
            <!-- Exclamation Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01M21 12c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8z"/>
            </svg>
            <span>You have not enrolled in any courses yet.</span>
        </div>
    @endif
</div>
