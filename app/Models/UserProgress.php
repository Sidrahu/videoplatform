<?php

namespace App\Models;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $fillable = ['user_id', 'course_id','progress', 'video_id', 'progress_percentage','last_position'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    // App\Models\UserProgress.php

public function getPercentageAttribute()
{
    $videoProgress = $this->calculateVideoProgress(); // 0–50
    $quizProgress = $this->calculateQuizProgress();   // 0–50

    return round($videoProgress + $quizProgress);
}

protected function calculateVideoProgress()
{
    // Get all videos of this course via chapters
    $chapters = $this->course->chapters; // assuming relation exists
    $videoIds = collect();

    foreach ($chapters as $chapter) {
        $videoIds = $videoIds->merge($chapter->videos->pluck('id'));
    }

    $totalVideos = $videoIds->count();

    $watchedVideos = $this->user->watchedVideos()
        ->whereIn('video_id', $videoIds)
        ->count();

    if ($totalVideos == 0) return 0;

    return ($watchedVideos / $totalVideos) * 50;
}


protected function calculateQuizProgress()
{
    $quizResult = $this->user->results()
                      ->where('course_id', $this->course->id)
                      ->first();

    if (!$quizResult || $quizResult->total_score == 0) return 0;

    return ($quizResult->score / $quizResult->total_score) * 50;
}



}

