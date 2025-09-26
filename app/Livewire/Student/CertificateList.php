<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class CertificateList extends Component
{
    public $certificates;

    public function mount()
    {
        // Get all quiz results for the authenticated user (no passing marks filter)
        $this->certificates = Result::with(['quiz.chapter.course'])
            ->where('user_id', Auth::id())
            ->get();
    }

    public function render()
    {
        return view('livewire.student.certificate-list')
            ->layout('layouts.app');
    }
}
