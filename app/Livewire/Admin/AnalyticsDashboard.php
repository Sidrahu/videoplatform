<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\UserProgress;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AnalyticsDashboard extends Component
{
    public $studentsChartData = [];
    public $engagementData = [];
    public $totalCourses;
    public $totalUsers;
    public $totalChapters;
    public $sidebarCourses;
    public $quizData = [];


    public function mount()
    {
        $this->totalCourses = Course::count();
        $this->totalUsers = User::count();
        $this->totalChapters = Chapter::count();

        // 🧠 Top 5 Students (Excluding Admins)
        $students = User::whereHas('roles', fn($q) => $q->where('name', '!=', 'admin'))
            ->withCount('progress')
            ->orderByDesc('progress_count')
            ->take(5)
            ->get();

        $this->studentsChartData = [
            'labels' => $students->pluck('name')->toArray(),
            'data' => $students->pluck('progress_count')->toArray(),
        ];

        // 📊 Course Engagement by Progress Count
        $courses = Course::withCount('progress')->get();

        $this->engagementData = [
            'labels' => $courses->pluck('title')->toArray(),
            'data' => $courses->pluck('progress_count')->toArray(),
        ];


        $quizAverages = Course::with(['quizzes.results'])->get()->map(function ($course) {
    $scores = [];

    foreach ($course->quizzes as $quiz) {
        foreach ($quiz->results as $result) {
            $scores[] = $result->score;
        }
    }

    $average = count($scores) > 0 ? round(array_sum($scores) / count($scores), 2) : 0;

    return [
        'title' => $course->title,
        'average_score' => $average,
    ];
});

$this->quizData = [
    'labels' => $quizAverages->pluck('title')->toArray(),
    'data' => $quizAverages->pluck('average_score')->toArray(),
];


        // 🎯 User Progress for Sidebar (Based on Completed Chapters)
        $this->sidebarCourses = [];
        $userId = Auth::id();

        if (Schema::hasColumn('user_progress', 'chapter_id')) {
            $this->sidebarCourses = Course::with('chapters')->get()->map(function ($course) use ($userId) {
                $totalChapters = $course->chapters->count();

                $completedChapters = UserProgress::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->distinct('chapter_id')
                    ->count('chapter_id');

                $progress = $totalChapters > 0
                    ? round(($completedChapters / $totalChapters) * 100)
                    : 0;

                return [
                    'title' => $course->title,
                    'progress' => $progress,
                ];
            });
        }
    }

    public function render()
    {
        return view('livewire.admin.analytics-dashboard')
            ->layout('layouts.app');
    }
}
