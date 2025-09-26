@if(auth()->check() && auth()->user()->hasRole('student'))
<aside class="w-64 bg-white shadow-xl rounded-r-2xl border-r border-gray-200 min-h-screen">
    <!-- Header -->
    <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-tr-2xl rounded-br-2xl shadow text-white">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            Student Panel
        </h2>
    </div>

    <nav class="p-4 space-y-1 text-sm text-gray-700 font-medium">
        <!-- Dashboard -->
        <a href="{{ route('student.dashboard') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-blue-50 transition">
            <i data-lucide="home" class="w-5 h-5 text-blue-600"></i>
            <span>Dashboard</span>
        </a>

        <!-- All Courses -->
        <div class="mt-4 mb-2 text-gray-500 uppercase text-xs font-semibold tracking-wider px-4">
            My Courses
        </div>

        <a href="{{ route('student.courses') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-blue-50 transition">
            <i data-lucide="book-open" class="w-5 h-5 text-indigo-600"></i>
            <span>All Courses</span>
        </a>

        <!-- Enrolled Courses + Chapters -->
        @php
            $enrolledCourses = auth()->user()->enrolledCourses()->with('chapters')->get();
        @endphp

        @if($enrolledCourses->count())
            <div class="mt-4 mb-2 text-gray-500 uppercase text-xs font-semibold tracking-wider px-4">
                Enrolled Courses
            </div>

            @foreach ($enrolledCourses as $course)
                <!-- Course -->
                <details class="group">
                    <summary class="flex items-center gap-2 px-4 py-2 rounded-xl cursor-pointer hover:bg-blue-50 transition">
                        <i data-lucide="bookmark" class="w-4 h-4 text-blue-500"></i>
                        <span>{{ Str::limit($course->title, 20) }}</span>
                        <i data-lucide="chevron-down" class="ml-auto group-open:rotate-180 transition-transform w-4 h-4"></i>
                    </summary>

                    <div class="ml-6 mt-1 space-y-1">
                        @foreach($course->chapters as $chapter)
                            <a href="{{ route('student.course.show', [$course->id, '#chapter-' . $chapter->id]) }}"
                               class="flex items-center gap-2 px-4 py-1 text-xs rounded hover:bg-blue-100 text-gray-600">
                                <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400"></i>
                                {{ Str::limit($chapter->title, 22) }}
                            </a>
                        @endforeach

                        @if($course->quiz)
                            <a href="{{ route('quiz', $course->quiz->id) }}"
                               class="flex items-center gap-2 px-4 py-1 text-blue-600 text-xs hover:underline">
                                <i data-lucide="pencil" class="w-3 h-3"></i>
                                Take Quiz
                            </a>
                        @endif
                    </div>
                </details>
            @endforeach
        @endif

        <!-- Tools -->
        <div class="mt-4 mb-2 text-gray-500 uppercase text-xs font-semibold tracking-wider px-4">
            Tools
        </div>

        <a href="{{ route('student.results') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-blue-50 transition">
            <i data-lucide="bar-chart-3" class="w-5 h-5 text-green-600"></i>
            <span>Results</span>
        </a>

        <a href="{{ route('student.quizzes') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-blue-50 transition">
            <i data-lucide="file-text" class="w-5 h-5 text-pink-600"></i>
            <span>Quizzes</span>
        </a>

        <a href="{{ route('student.certificates') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-blue-50 transition">
            <i data-lucide="award" class="w-5 h-5 text-yellow-500"></i>
            <span>Certificates</span>
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit"
                    class="flex items-center gap-2 w-full px-4 py-2 rounded-xl text-red-600 hover:bg-red-50 transition">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>
</aside>
@endif
