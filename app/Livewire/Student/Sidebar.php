<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class Sidebar extends Component
{
    public function render()
    {
        $courses = Auth::user()->courses; // assuming belongsToMany relationship
        return view('livewire.student.sidebar', compact('courses'));
    }
}

