<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Result;

class StudentDashboard extends Component
{
    public $myCourses;
    public $results;
    public $certificates;

    public function mount()
    {
        $user = Auth::user();

        // Enrolled courses
        $this->myCourses = $user->enrolledCourses()->get();

        // Latest quiz results (latest 5)
        $this->results = $user->Results()->with('quiz')->latest()->take(5)->get();

        // All certificates (based on results regardless of passing marks)
        $this->certificates = $user->certificates()->with('quiz')->get();
    }

    public function render()
    {
        return view('livewire.student.student-dashboard')
            ->layout('layouts.app');
    }
}
