<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Course;
use App\Models\UserProgress;
use App\Models\Enrollment;

class CourseProgress extends Component
{
    public $course;
    public $students = []; // aggregated rows
    public $totalVideos = 0;
    public $avgCourseProgress = 0;
    public $completionRate = 0; // % students >= 100

    public function mount($courseId)
    {
        $this->course = Course::with('chapters.videos')->findOrFail($courseId);

        // Total videos in this course
        $this->totalVideos = $this->course->chapters->flatMap->videos->count();

        // Get enrolled users
        $enrolledUserIds = Enrollment::where('course_id', $courseId)->pluck('user_id');

        // Get progress rows for those users
        $progressRows = UserProgress::with('user')
            ->where('course_id', $courseId)
            ->whereIn('user_id', $enrolledUserIds)
            ->get()
            ->groupBy('user_id');

        $allPercents = [];
        $completedCount = 0;

        foreach ($progressRows as $userId => $rows) {
            $user = $rows->first()->user;

            // Average % across all videos where progress exists
            $avg = round($rows->avg('progress_percentage'));

            // Videos watched (>0%)
            $watchedCount = $rows->where('progress_percentage', '>', 0)->count();

            // Completed videos (>=95% watched — adjustable)
            $completedVideos = $rows->where('progress_percentage', '>=', 95)->count();

            // Course completed? (avg >= 95 OR all videos completed)
            $isCompleted = $this->totalVideos > 0
                ? ($completedVideos >= $this->totalVideos || $avg >= 95)
                : false;

            if ($isCompleted) {
                $completedCount++;
            }

            $allPercents[] = $avg;

            $this->students[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avg' => $avg,
                'watched' => $watchedCount,
                'total' => $this->totalVideos,
                'completed' => $isCompleted,
            ];
        }

        // Overall averages
        if (count($allPercents) > 0) {
            $this->avgCourseProgress = round(collect($allPercents)->avg());
            $this->completionRate = round(($completedCount / count($allPercents)) * 100);
        }
    }

    public function render()
    {
        // Sort descending by avg progress
        $students = collect($this->students)->sortByDesc('avg')->values();

        return view('livewire.admin.course-progress', [
            'students' => $students,
        ])->layout('layouts.app');
    }
}
