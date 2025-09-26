<div class="p-6 max-w-6xl mx-auto space-y-10">

    {{-- Welcome --}}
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-8 rounded-2xl shadow-xl">
        <h1 class="text-4xl font-extrabold flex items-center gap-2">
            <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            Welcome, {{ Auth::user()->name }}
        </h1>
        <p class="mt-2 text-lg font-light">Glad to see you progressing in your learning journey!</p>
    </div>

    {{-- My Courses --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2 mb-4">
            <i data-lucide="book-open" class="w-5 h-5 text-indigo-500"></i>
            My Courses
        </h2>
        @if($myCourses->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($myCourses as $course)
                    <div class="p-4 border rounded-xl shadow hover:shadow-lg transition-all bg-gray-50 hover:bg-white">
                        <h3 class="text-lg font-semibold text-indigo-700">
                            <i data-lucide="layers" class="inline-block w-4 h-4 mr-1 text-indigo-400"></i>
                            {{ $course->title }}
                        </h3>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No courses enrolled yet.</p>
        @endif
    </div>

    {{-- Latest Quiz Results --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2 mb-4">
            <i data-lucide="clipboard-list" class="w-5 h-5 text-pink-500"></i>
            Latest Quiz Results
        </h2>
        @if($results->count())
            <ul class="space-y-4">
                @foreach($results as $result)
                    <li class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border">
                        <div class="flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4 text-gray-500"></i>
                            <span class="font-medium text-gray-700">{{ $result->quiz->title ?? 'Unknown Quiz' }}</span>
                        </div>
                        <div class="text-green-600 font-semibold text-sm flex items-center gap-1">
                            <i data-lucide="bar-chart-2" class="w-4 h-4"></i> {{ $result->score }}%
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No quiz results available.</p>
        @endif
    </div>

    {{-- Certificates --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2 mb-4">
            <i data-lucide="award" class="w-5 h-5 text-yellow-500"></i>
            Certificates Earned
        </h2>
        @if($certificates->count())
            <ul class="space-y-4">
                @foreach($certificates as $certificate)
                    <li class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border">
                        <div class="flex items-center gap-2">
                            <i data-lucide="file-badge" class="w-4 h-4 text-blue-400"></i>
                            <span class="text-gray-700 font-medium">{{ $certificate->quiz->title ?? 'Unknown Quiz' }}</span>
                        </div>
                        <div class="text-blue-600 font-semibold text-sm flex items-center gap-1">
                            <i data-lucide="target" class="w-4 h-4"></i> {{ $certificate->score }}%
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No certificates earned yet.</p>
        @endif
    </div>

</div>
