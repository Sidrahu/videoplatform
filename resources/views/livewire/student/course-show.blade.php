<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-2">{{ $course->title }}</h1>
    <p class="text-gray-600 mb-6">{{ $course->description }}</p>

    @if(!$isEnrolled)
        <button wire:click="enroll"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-full shadow transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>
            Enroll Now
        </button>
    @else
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded shadow mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2l4 -4"/>
            </svg>
            You are enrolled in this course.
        </div>
    @endif

    @if($isEnrolled && $course->quizzes->count() > 0)
        <div class="mb-8 bg-white shadow-md rounded-lg p-6 border">
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 4h2a2 2 0 012 2v14l-7-3l-7 3V6a2 2 0 012-2h2"/>
                </svg>
                Quiz
            </h2>

            @if(!$quizAttempted)
                <a href="{{ route('student.quiz', $course->quizzes->first()->id) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full shadow transition inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v13a2 2 0 01-2 2z"/>
                    </svg>
                    Take Quiz
                </a>
            @else
                <div class="bg-gray-50 p-4 rounded-lg border shadow-sm">
                    <p class="font-semibold text-green-700 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        You have already attempted this quiz.
                    </p>
                    <p class="mt-2 text-gray-700">
                        Your Score:
                        <strong>{{ $quizResult->score }}/{{ $course->quizzes->first()->questions->count() }}</strong>
                    </p>
                    <a href="{{ route('student.certificate', $course->quizzes->first()->id) }}"
                       class="mt-3 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 12v9m0 0H8m4 0h4M8 6h8m-8 4h8M8 6a2 2 0 012-2h4a2 2 0 012 2"/>
                        </svg>
                        Download Certificate
                    </a>
                </div>
            @endif
        </div>
    @endif

    @if($isEnrolled)
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Chapters
            </h2>

            @foreach($course->chapters as $chapter)
                <div class="bg-white shadow-sm rounded-lg p-5 mb-6 border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">{{ $chapter->title }}</h3>
                    <p class="text-gray-600">{{ $chapter->description }}</p>

                    @if($chapter->resource)
                        <a href="{{ asset('storage/' . $chapter->resource) }}" download
                           class="text-blue-600 hover:underline inline-flex items-center gap-2 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v16h16V4H4zm4 8h8m-4-4v8"/>
                            </svg>
                            Download Resource
                        </a>
                    @endif

                    <ul class="mt-3 pl-4 list-disc text-sm text-blue-600">
                        @foreach($chapter->videos as $video)
                            <li>
                                <a href="{{ route('student.watch', $video->id) }}"
                                   class="hover:underline">{{ $video->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
</div>
