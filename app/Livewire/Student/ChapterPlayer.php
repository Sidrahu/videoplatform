<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Video;
use App\Models\UserProgress;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class ChapterPlayer extends Component
{
    public $video;
    public $lastPosition = 0;   // seconds
    public $progress = 0;       // %
    public $isAuthorized = false;

    protected $listeners = ['updateProgress' => 'saveProgress'];

    public function mount($videoId)
    {
        $this->video = Video::with('chapter.course')->findOrFail($videoId);

        // Enrollment check
        $this->isAuthorized = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $this->video->chapter->course_id)
            ->exists();

        if ($this->isAuthorized) {
            $record = UserProgress::where('user_id', Auth::id())
                ->where('video_id', $videoId)
                ->first();

            if ($record) {
                $this->lastPosition = (int) ($record->last_position ?? 0);
                $this->progress     = (int) ($record->progress_percentage ?? 0);
            }
        }
    }

    /**
     * Save incoming progress safely:
     * - Never reduce % (keep max)
     * - Never reduce last_position (unless user truly rewinds & you WANT that; usually keep max)
     * - Auto force 100% when >= 98%
     */
    public function saveProgress($seconds, $percentage)
    {
        if (!$this->isAuthorized) {
            return;
        }

        $seconds     = (int) $seconds;
        $percentage  = (int) $percentage;

        // Force 100 if nearly done
        if ($percentage >= 98) {
            $percentage = 100;
        }

        $existing = UserProgress::where('user_id', Auth::id())
            ->where('video_id', $this->video->id)
            ->first();

        if ($existing) {
            // Never go backwards in % or position
            $percentage = max($existing->progress_percentage, $percentage);
            $seconds    = max($existing->last_position, $seconds);
        }

        UserProgress::updateOrCreate(
            [
                'user_id'   => Auth::id(),
                'video_id'  => $this->video->id,
                'course_id' => $this->video->chapter->course_id,
            ],
            [
                'last_position'       => $seconds,
                'progress_percentage' => $percentage,
            ]
        );

        // Update local Livewire state so UI bar moves
        $this->lastPosition = $seconds;
        $this->progress     = $percentage;
    }

    public function render()
    {
        return view('livewire.student.chapter-player', [
            'video'        => $this->video,
            'isAuthorized' => $this->isAuthorized,
            'progress'     => $this->progress,
            'lastPosition' => $this->lastPosition,
        ])->layout('layouts.app');
    }
}
