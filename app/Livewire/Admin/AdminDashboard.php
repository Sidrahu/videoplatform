<?php
namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Result;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $totalUsers;
    public $totalCourses;
    public $quizResults;
    public $enrollments;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->totalCourses = Course::count();
        $this->quizResults = Result::with('user', 'quiz', 'quiz.questions')->latest()->take(10)->get();
        $this->enrollments = Enrollment::with('user', 'course')->latest()->take(10)->get();
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard')
         ->layout('layouts.app');
    }
}
