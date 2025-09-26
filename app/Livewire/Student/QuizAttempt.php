<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class QuizAttempt extends Component
{
    public $quiz;
    public $answers = [];
    public $score = null;
    public $alreadyAttempted = false;

    public function mount($quizId)
    {
        $this->quiz = Quiz::with('questions')->findOrFail($quizId);

        // Check if the user already attempted this quiz
        $result = Result::where('user_id', Auth::id())
                        ->where('quiz_id', $quizId)
                        ->first();
        if ($result) {
            $this->alreadyAttempted = true;
            $this->score = $result->score; // Show previous score
        }
    }

    public function submit()
    {
        if ($this->alreadyAttempted) {
            return; // Prevent re-submission
        }

        $score = 0;
        foreach ($this->quiz->questions as $q) {
            if (isset($this->answers[$q->id]) && $this->answers[$q->id] == $q->correct_option) {
                $score++;
            }
        }
        $this->score = $score;
        $this->alreadyAttempted = true;

        Result::create([
            'user_id' => Auth::id(),
            'quiz_id' => $this->quiz->id,
            'score' => $score
        ]);
    }

    public function render()
    {
        return view('livewire.student.quiz-attempt')
            ->layout('layouts.app');
    }
}
