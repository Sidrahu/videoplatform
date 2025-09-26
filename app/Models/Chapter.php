<?php

namespace App\Models;
use App\Models\Course;
use App\Models\Video;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['course_id', 'title', 'description', 'order','resource'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

 public function quiz()
{
    return $this->hasMany(Quiz::class);
}



}
