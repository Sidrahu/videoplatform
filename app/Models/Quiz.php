<?php

namespace App\Models;
use App\Models\Course;
use App\Models\Question;
use App\Models\Result;
use App\Models\certificate;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['course_id', 'title'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
    public function chapter()
{
    return $this->belongsTo(Chapter::class);
}
public function certificates()
{
    return $this->hasMany(Certificate::class);
}


}
