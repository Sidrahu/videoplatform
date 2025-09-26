<?php

namespace App\Livewire\Student;

use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuizList extends Component
{
    public $quizzesWithStatus = [];

    public function mount()
    {
        $userId = Auth::id();

        $quizzes = Quiz::with('course')->get(); // aapka logic ho sakta course-wise bhi ho
        foreach ($quizzes as $quiz) {
            $result = Result::where('quiz_id', $quiz->id)->where('user_id', $userId)->first();

            $this->quizzesWithStatus[] = [
                'quiz' => $quiz,
                'attempted' => $result ? true : false,
                'result' => $result,
            ];
        }
    }

    public function render()
    {
        return view('livewire.student.quiz-list', [
            'quizzesWithStatus' => $this->quizzesWithStatus,
        ])->layout('layouts.app');
    }
}
