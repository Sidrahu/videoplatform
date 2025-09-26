<?php

namespace App\Livewire\Student;

use Livewire\Component;

class StudentProgress extends Component
{
    public function render()
    {
        return view('livewire.student.student-progress')
         ->layout('layouts.app');
    }
}
