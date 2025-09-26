<div class="py-10">
    <div class="max-w-4xl mx-auto px-6 bg-white shadow-md rounded-2xl p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 6H21M8 12H21M8 18H21M3 6H3.01M3 12H3.01M3 18H3.01"/>
            </svg>
            {{ $quiz->title }}
        </h2>

        @if ($alreadyAttempted)
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-4 rounded-xl mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <p>You have already attempted this quiz.</p>
                    <p class="mt-1 text-sm font-semibold">Your Score: {{ $score }}/{{ count($quiz->questions) }}</p>
                </div>
            </div>

            <a href="{{ route('student.results') }}"
               class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12H9m0 0l3-3m-3 3l3 3"/>
                </svg>
                View My Results
            </a>
        @else
            <form wire:submit.prevent="submit">
                <div class="space-y-6">
                    @foreach($quiz->questions as $question)
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl">
                            <p class="font-semibold text-gray-800 mb-2">
                                {{ $loop->iteration }}. {{ $question->question_text }}
                            </p>
                            <div class="space-y-2">
                                @foreach($question->options as $option)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" wire:model="answers.{{ $question->id }}"
                                               value="{{ $option }}"
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="text-gray-700">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        Submit Quiz
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
