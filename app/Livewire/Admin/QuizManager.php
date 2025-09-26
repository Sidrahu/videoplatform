<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Question;
use App\Models\Result; // ADD THIS
use App\Models\User;   // For user names

class QuizManager extends Component
{
    public $course_id, $title;
    public $questions = [];
    public $question_text, $option1, $option2, $option3, $option4, $correct_option;
    public $quizId;

    // CREATE QUIZ
    public function createQuiz()
    {
        $this->validate([
            'course_id' => 'required|exists:courses,id',
            'title'     => 'required|string|max:255'
        ]);

        $quiz = Quiz::create([
            'course_id' => $this->course_id,
            'title'     => $this->title
        ]);

        $this->quizId = $quiz->id;
        $this->loadQuestions(); 
        session()->flash('message', 'Quiz created! Add questions now.');
    }

    // SELECT QUIZ
    public function selectQuiz($quizId)
    {
        $this->quizId = $quizId;
        $this->loadQuestions();
    }

    // LOAD QUESTIONS
    public function loadQuestions()
    {
        $this->questions = Question::where('quiz_id', $this->quizId)->get();
    }

    // ADD QUESTION
    public function addQuestion()
    {
        $this->validate([
            'question_text'  => 'required|string',
            'option1'        => 'required|string',
            'option2'        => 'required|string',
            'option3'        => 'required|string',
            'option4'        => 'required|string',
            'correct_option' => 'required|string'
        ]);

        Question::create([
            'quiz_id'        => $this->quizId,
            'question_text'  => $this->question_text,
            'options'        => [
                $this->option1,
                $this->option2,
                $this->option3,
                $this->option4
            ],
            'correct_option' => $this->correct_option
        ]);

        $this->reset(['question_text', 'option1', 'option2', 'option3', 'option4', 'correct_option']);
        $this->loadQuestions();

        session()->flash('message', 'Question added!');
    }

    // RENDER
    public function render()
    {
        $results = [];

        if ($this->quizId) {
            // Load results of selected quiz
            $results = Result::with('user')
                ->where('quiz_id', $this->quizId)
                ->get();
        }

        return view('livewire.admin.quiz-manager', [
            'courses'  => Course::all(),
            'quizzes'  => Quiz::with('questions')->get(),
            'questions'=> $this->questions,
            'results'  => $results, // pass to view
        ])->layout('layouts.app');
    }
}
