<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;

class CourseDetail extends Component
{
    public $course;
    public $isEnrolled = false;
    public $quizAttempted = false;
    public $quizResult;

    public function mount(Course $course)
    {
        $this->course = $course;

        // Check enrollment
        $this->isEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)->exists();

        // Check if quiz attempted
        if ($this->isEnrolled && $course->quizzes->count() > 0) {
            $this->quizResult = QuizResult::where('user_id', Auth::id())
                ->where('quiz_id', $course->quizzes->first()->id)
                ->first();

            $this->quizAttempted = $this->quizResult !== null;
        }
    }

    public function enroll()
    {
        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $this->course->id,
        ]);

        $this->isEnrolled = true;
        session()->flash('message', 'You have been enrolled in this course.');
    }

    public function render()
    {
        return view('livewire.student.course-detail');
    }
}
