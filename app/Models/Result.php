<?php

namespace App\Models;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['user_id', 'quiz_id', 'score','passed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
  public function courses()
    {
        return $this->belongsTo(Course::class);
    }  
}

