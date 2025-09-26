<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0l3-3m-3 3l-3-3" />
        </svg>
        <span>Your Certificates</span>
    </h2>

    @forelse ($certificates as $certificate)
        @php
            $quiz = $certificate->quiz;
            $chapter = $quiz->chapter ?? null;
            $course = $chapter?->course ?? null;
        @endphp

        <div class="mb-6 p-6 bg-white rounded-2xl shadow-md border border-gray-200 hover:shadow-lg transition duration-200">
            <h3 class="text-xl font-semibold text-blue-700 mb-1 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 20l9-5-9-5-9 5 9 5z" />
                    <path d="M12 12V4m0 0L9 7m3-3l3 3" />
                </svg>
                {{ $quiz->title }}
            </h3>

            @if ($chapter && $course)
                <p class="text-gray-700 mt-1 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    <strong>Course:</strong> {{ $course->title }}
                </p>
                <p class="text-gray-700 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <strong>Chapter:</strong> {{ $chapter->title }}
                </p>
            @endif

            <p class="text-gray-600 mt-2 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M5 13l4 4L19 7" />
                </svg>
                <strong>Score:</strong> {{ $certificate->score }}%
            </p>

            <a href="{{ route('student.certificate', $certificate->quiz_id) }}"
               class="inline-flex items-center gap-2 mt-4 px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 16v-8m0 8l-4-4m4 4l4-4m8 4a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Download Certificate
            </a>
        </div>
    @empty
        <div class="text-center text-gray-600 mt-10 flex flex-col items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9.75 9.75h.008v.008H9.75v-.008zm4.5 0h.008v.008h-.008v-.008zM9.75 14.25h.008v.008H9.75v-.008zm4.5 0h.008v.008h-.008v-.008z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3a9 9 0 100 18 9 9 0 000-18z" />
            </svg>
            <p>You have not earned any certificates yet.</p>
        </div>
    @endforelse
</div>
