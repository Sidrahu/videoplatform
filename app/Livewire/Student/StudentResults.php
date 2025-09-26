<?php
 

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class StudentResults extends Component
{
    public $results;

    public function mount()
    {
        $this->results = Result::with('quiz')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.student.student-results')
            ->layout('layouts.app');
    }
}
