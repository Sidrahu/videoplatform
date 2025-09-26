<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class CertificateGenerator extends Component
{
    public $quizId;
    public $result;

    public function mount($quizId)
    {
        $this->quizId = $quizId;
        $this->result = Result::where('user_id', Auth::id())
            ->where('quiz_id', $quizId)
            ->with('quiz.questions', 'user')
            ->firstOrFail();
    }

    public function downloadCertificate()
    {
        $pdf = Pdf::loadView('certificate', ['result' => $this->result]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'certificate.pdf');
    }

    public function render()
    {
        return view('livewire.student.certificate-generator')
        ->layout('layouts.app');
    }
}

