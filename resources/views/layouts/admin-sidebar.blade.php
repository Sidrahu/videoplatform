@php use App\Models\Course; @endphp

@if(auth()->check() && auth()->user()->hasRole('admin'))
<div class="w-72 h-screen bg-white border-r shadow-xl flex flex-col" x-data="{ openCourses: true }">
    
    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-5 text-white">
        <h1 class="text-2xl font-bold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422A12.042 12.042 0 0112 21.5a12.042 12.042 0 01-6.16-10.922L12 14z"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Admin Panel
        </h1>
        <p class="text-sm mt-1 text-indigo-200">Welcome, Admin</p>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-2 text-sm text-gray-800">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24"><path d="M3 12l9-9 9 9v9a2 2 0 01-2 2H5a2 2 0 01-2-2z"
                                           stroke-linecap="round" stroke-linejoin="round"/></svg>
            Dashboard
        </a>

        {{-- Courses Dropdown --}}
        <div x-data="{ openCourses: true }" class="space-y-1">
            <button @click="openCourses = !openCourses"
                    class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-gray-100 transition font-semibold">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422A12.042 12.042 0 0112 21.5a12.042 12.042 0 01-6.16-10.922L12 14z"
                                               stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="ml-2">Courses</span>
                <svg class="ml-auto w-4 h-4 transform transition-transform"
                     :class="{'rotate-180': openCourses}" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"
                                               stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <div x-show="openCourses" class="ml-4 mt-1 space-y-1">
                <a href="{{ route('admin.courses') }}"
                   class="flex items-center gap-2 px-3 py-1 hover:bg-gray-100 rounded transition">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path d="M4 19h16M4 10h16M4 4h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    All Courses
                </a>

                {{-- Loop Courses --}}
                @foreach (Course::with('chapters.videos')->get() as $course)
                    <div x-data="{ openCourse{{ $course->id }}: false }">
                        <button @click="openCourse{{ $course->id }} = !openCourse{{ $course->id }}"
                                class="flex items-center w-full px-3 py-1 text-gray-700 hover:bg-gray-100 rounded transition">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            {{ $course->title }}
                            <svg class="ml-auto w-4 h-4 transform transition-transform"
                                 :class="{'rotate-180': openCourse{{ $course->id }}}" fill="none"
                                 stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"
                                                           stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>

                        <div x-show="openCourse{{ $course->id }}" class="ml-4 mt-1 space-y-1">
                            <a href="{{ route('admin.chapters', $course->id) }}"
                               class="flex items-center gap-2 px-3 py-1 hover:bg-gray-50 text-gray-600 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24"><path d="M4 4h16v16H4z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Chapters
                            </a>

                            @foreach ($course->chapters as $chapter)
                                <div class="ml-2">
                                    <div class="flex items-center gap-2 px-3 py-1 text-gray-700">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                             stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M3 7h4l2 2h10v10H3z"
                                                  stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        {{ $chapter->title }}
                                    </div>

                                    {{-- Videos --}}
                                    <a href="{{ route('admin.videos', $chapter->id) }}"
                                       class="flex items-center gap-2 px-6 py-1 text-gray-500 hover:bg-gray-50 rounded transition">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor"
                                             stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14V10z" />
                                            <path d="M4 6h16M4 18h16M4 6v12M20 6v12" />
                                        </svg>
                                        Videos
                                    </a>

                                    {{-- PDF --}}
                                    @if($chapter->resource)
                                        <a href="{{ asset('storage/' . $chapter->resource) }}"
                                           target="_blank"
                                           class="flex items-center gap-2 px-6 py-1 text-green-600 hover:underline transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                 stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M12 20h9M12 4v16m-6-6h6m0-6H6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            View PDF
                                        </a>
                                    @else
                                        <span class="flex items-center gap-2 px-6 py-1 text-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                 stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            No PDF
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Quizzes --}}
        <a href="{{ route('admin.quizzes') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Quizzes
        </a>

        {{-- Progress --}}
        @php $coursesWithProgress = Course::orderBy('title')->get(); @endphp
        @if ($coursesWithProgress->isNotEmpty())
            <div x-data="{ openProgress: false }" class="space-y-1">
                <button @click="openProgress = !openProgress"
                        class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path d="M11 3h10v18H3V3h8z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="ml-2">Progress</span>
                    <svg class="ml-auto w-4 h-4 transform transition-transform"
                         :class="{ 'rotate-180': openProgress }" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"
                                                   stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>

                <div x-show="openProgress" x-transition class="ml-6 mt-1 space-y-1">
                    @foreach ($coursesWithProgress as $course)
                        <a href="{{ route('course.progress', $course->id) }}"
                           class="flex items-center gap-2 px-3 py-1 hover:bg-gray-100 rounded transition text-gray-700">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path d="M3 3v18h18" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            {{ $course->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Analytics --}}
        <a href="{{ route('admin.analytics') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Analytics
        </a>
    </nav>

    {{-- Footer --}}
    <div class="p-3 border-t text-xs text-gray-400 text-center">
        © {{ date('Y') }} LMS Admin
    </div>
</div>
@endif
