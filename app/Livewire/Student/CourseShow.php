<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class CourseShow extends Component
{
    public $course;
    public $isEnrolled = false;
    public $quizAttempted = false;
    public $quizResult = null;

    

  public function mount($courseId)
{
    $this->course = Course::with(['chapters.videos', 'quizzes.questions'])->findOrFail($courseId);

    // ✅ Only if user is logged in
    if (Auth::check()) {
        $user = Auth::user();

        // ✅ Check if user already viewed
        $alreadyViewed = \DB::table('course_user_views')
            ->where('user_id', $user->id)
            ->where('course_id', $this->course->id)
            ->exists();

        // ✅ If not viewed before, record & increment views
        if (!$alreadyViewed) {
            \DB::table('course_user_views')->insert([
                'user_id' => $user->id,
                'course_id' => $this->course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->course->increment('views');
        }

        // ✅ Check if the user is enrolled
        $this->isEnrolled = Enrollment::where('user_id', $user->id)
            ->where('course_id', $this->course->id)
            ->exists();

        // ✅ Check if quiz is already attempted
        if ($this->course->quizzes->count() > 0) {
            $quizId = $this->course->quizzes->first()->id;

            $this->quizAttempted = Result::where('user_id', $user->id)
                ->where('quiz_id', $quizId)
                ->exists();

            if ($this->quizAttempted) {
                $this->quizResult = Result::where('user_id', $user->id)
                    ->where('quiz_id', $quizId)
                    ->first();
            }
        }
    }
}


    public function enroll()
    {
        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $this->course->id,
        ]);

        $this->isEnrolled = true;
        session()->flash('message', 'You have successfully enrolled!');
    }

    public function render()
    {
        return view('livewire.student.course-show')
            ->layout('layouts.app');
    }
}
