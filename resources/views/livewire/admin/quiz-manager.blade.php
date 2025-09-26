<div class="max-w-5xl mx-auto px-6 py-8">
    <!-- Page Title -->
    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">
        <svg class="w-7 h-7 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0118 21l-6-3-6 3v-1.055a12.083 12.083 0 01.16-10.367L12 14z" />
        </svg>
        Manage Quizzes
    </h2>

    <!-- Success Message -->
    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Create Quiz -->
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-8">
        <div class="flex items-center gap-2 mb-4 text-gray-700 font-semibold text-lg">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create New Quiz
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <select wire:model="course_id" class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-indigo-500">
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>

            <input wire:model="title" type="text" placeholder="Quiz Title" class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-indigo-500">
        </div>

        <button wire:click="createQuiz" class="mt-5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded shadow">
            Create Quiz
        </button>
    </div>

    <!-- Existing Quizzes -->
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-8">
        <div class="flex items-center gap-2 mb-4 text-gray-700 font-semibold text-lg">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-6-8l6 6-6 6" />
            </svg>
            Existing Quizzes
        </div>

        @if($quizzes->count())
            <ul class="divide-y divide-gray-200">
                @foreach($quizzes as $quiz)
                    <li class="py-3 flex justify-between items-center">
                        <span class="text-gray-800 font-medium">{{ $quiz->title }}</span>
                        <button wire:click="selectQuiz({{ $quiz->id }})" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-1.5 rounded text-sm shadow">
                            Manage Questions
                        </button>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No quizzes created yet.</p>
        @endif
    </div>

    <!-- Add Question -->
    @if($quizId)
        <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-8">
            <div class="flex items-center gap-2 mb-4 text-gray-700 font-semibold text-lg">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Question
            </div>

            <input wire:model="question_text" type="text" placeholder="Question Text"
                   class="border border-gray-300 rounded px-3 py-2 w-full mb-3 focus:ring-2 focus:ring-indigo-500">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                <input wire:model="option1" type="text" placeholder="Option 1" class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <input wire:model="option2" type="text" placeholder="Option 2" class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <input wire:model="option3" type="text" placeholder="Option 3" class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <input wire:model="option4" type="text" placeholder="Option 4" class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            </div>

            <input wire:model="correct_option" type="text" placeholder="Correct Option"
                   class="border border-gray-300 rounded px-3 py-2 w-full mb-4 focus:ring-2 focus:ring-green-500">

            <button wire:click="addQuestion"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded shadow">
                Add Question
            </button>
        </div>

        <!-- Show Questions -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-8">
            <div class="flex items-center gap-2 mb-4 text-gray-700 font-semibold text-lg">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 00-8 0v4a4 4 0 008 0V7z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 4h.01" />
                </svg>
                Questions in This Quiz
            </div>

            @if(count($questions) > 0)
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    @foreach($questions as $q)
                        <li>
                            <strong>{{ $q->question_text }}</strong>
                            <span class="text-sm text-gray-500">(Correct: {{ $q->correct_option }})</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No questions added yet.</p>
            @endif
        </div>

        <!-- Quiz Attempts -->
        @if(isset($results) && count($results))
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-8">
                <div class="flex items-center gap-2 mb-4 text-gray-700 font-semibold text-lg">
                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 118 0v2m-6 4h4" />
                    </svg>
                    Quiz Attempts
                </div>

                <table class="w-full border border-gray-300 text-sm rounded">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="p-2 border">User</th>
                            <th class="p-2 border">Score</th>
                            <th class="p-2 border">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr class="text-gray-700">
                                <td class="p-2 border">{{ $result->user->name }}</td>
                                <td class="p-2 border">{{ $result->score }}/{{ $questions->count() }}</td>
                                <td class="p-2 border">{{ $result->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 mb-6">No user has attempted this quiz yet.</p>
        @endif
    @endif
</div>
