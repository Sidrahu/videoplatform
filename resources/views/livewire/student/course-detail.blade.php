<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-xl shadow-md">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $course->title }}</h1>
            <p class="text-gray-600 mb-6">{{ $course->description }}</p>

            @if(!$isEnrolled)
                <button wire:click="enroll"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-300">
                    ✅ Enroll Now
                </button>
            @else
                <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6 border-l-4 border-green-500">
                    🎉 You are enrolled in this course.
                </div>
            @endif

            {{-- Quiz & Certificate --}}
            @if($isEnrolled && $course->quizzes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    @if(!$quizAttempted)
                        <div class="bg-blue-100 p-6 rounded-lg shadow-sm flex flex-col items-start justify-between">
                            <p class="text-lg font-semibold text-blue-800 mb-3">📝 Ready to take the quiz?</p>
                            <a href="{{ route('student.quiz', $course->quizzes->first()->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition">
                                Take Quiz
                            </a>
                        </div>
                    @else
                        <div class="bg-indigo-100 p-6 rounded-lg shadow-sm">
                            <p class="text-lg font-semibold text-indigo-800 mb-2">✅ You have already attempted this quiz.</p>
                            <p class="text-gray-700 mb-4">
                                Score:
                                <strong class="text-indigo-700">
                                    {{ $quizResult->score }}/{{ $course->quizzes->first()->questions->count() }}
                                </strong>
                            </p>
                            <a href="{{ route('student.certificate', $course->quizzes->first()->id) }}"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition text-sm font-medium">
                                🎓 Download Certificate
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Chapters --}}
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">📚 Chapters</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($course->chapters as $chapter)
                    <div class="bg-white border border-gray-200 p-6 rounded-lg shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">{{ $chapter->title }}</h3>
                            <p class="text-gray-600 mt-1">{{ $chapter->description }}</p>

                            @if($chapter->resource)
                                <a href="{{ asset('storage/' . $chapter->resource) }}" download
                                    class="mt-3 block text-blue-600 hover:text-blue-800 underline text-sm">
                                    📎 Download Resource
                                </a>
                            @endif
                        </div>

                        <ul class="mt-4 list-disc list-inside text-gray-700 space-y-1">
                            @foreach($chapter->videos as $video)
                                <li>
                                    <a href="{{ route('student.watch', $video->id) }}"
                                       class="text-blue-500 hover:underline">{{ $video->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
