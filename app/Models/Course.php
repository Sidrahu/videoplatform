<?php

namespace App\Models;
use App\Models\Chapter;
use App\Models\Quiz;
use App\Models\Enrollment;
use App\Models\Result;
use App\Models\User;
use App\Models\Video;
use App\Models\UserProgress;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'thumbnail'];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}

    public function results()
{
    return $this->hasMany(Result::class);
}

public function progress()
{
    return $this->hasMany(UserProgress::class);
}
public function users()
{
    return $this->belongsToMany(User::class);
}

public function videos()
{
    return $this->hasMany(Video::class);
}


}
