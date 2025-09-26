<?php

namespace App\Models;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'status', // e.g. 'pending', 'approved'
        'issued_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
 

public function quiz()
{
    return $this->belongsTo(Quiz::class);
}

}
