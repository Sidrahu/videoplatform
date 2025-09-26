<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course; // 👈 model import
use Illuminate\Support\Facades\Auth;

class AllCourses extends Component
{
    public $courses = [];

    public function mount()
    {
        $this->courses = Course::all(); // ✅ Now refers to model
    }

    public function render()
    {
        return view('livewire.student.course-list')
            ->layout('layouts.app');
    }
}
