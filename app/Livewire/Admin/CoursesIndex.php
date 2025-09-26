<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Course;
use App\Models\Enrollment;

class CoursesIndex extends Component
{
    public function render()
    {
        // Courses with total enrolled count
        $courses = Course::withCount(['enrollments'])->get();

        return view('livewire.admin.courses-index', [
            'courses' => $courses,
        ])->layout('layouts.app'); // change layout if needed
    }
}

