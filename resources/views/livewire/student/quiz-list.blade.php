<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-3xl font-bold mb-10 text-center text-gray-800 flex items-center justify-center gap-3">
        <i class="fas fa-clipboard-list text-blue-600 text-3xl"></i>
        <span>Available Quizzes</span>
    </h2>

    @forelse ($quizzesWithStatus as $item)
        <div class="mb-8 p-6 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
            <h3 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-question-circle text-blue-500"></i>
                {{ $item['quiz']->title }}
            </h3>

            <p class="text-gray-600 mt-2">{{ $item['quiz']->description }}</p>

            @if (!$item['attempted'])
                <a href="{{ route('student.quiz', $item['quiz']->id) }}"
                   class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-pen"></i> Attempt Quiz
                </a>
            @else
                <div class="mt-4 space-y-2">
                    <p class="text-green-600 font-medium flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> You have already attempted this quiz.
                    </p>
                    <p class="text-gray-700 flex items-center gap-2">
                        <i class="fas fa-bullseye text-yellow-500"></i>
                        <strong>Score:</strong> {{ $item['result']->score ?? 'N/A' }}
                    </p>

                    <a href="{{ route('student.certificate', $item['quiz']->id) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 mt-3 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-certificate"></i> Download Certificate
                    </a>
                </div>
            @endif
        </div>
    @empty
        <div class="text-center text-gray-500 mt-20">
            <i class="fas fa-exclamation-circle text-4xl mb-3 text-gray-400"></i>
            <p class="text-lg">No quizzes found.</p>
        </div>
    @endforelse
</div>
