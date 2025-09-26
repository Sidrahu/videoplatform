<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Result;
use App\Models\Video;
use App\Models\certificate;
use App\Models\UserProgress;


use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
 

// In App\Models\User.php
// App\Models\User.php

public function enrolledCourses()
{
    return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')
                ->withTimestamps();
}

public function watchedVideos()
{
    return $this->belongsToMany(Video::class, 'video_views')->withTimestamps();
}

public function Results()
{
    return $this->hasMany(Result::class);
}



// App\Models\User.php
public function courses()
{
    return $this->belongsToMany(Course::class, 'course_user'); 
}

public function progress()
{
    return $this->hasMany(UserProgress::class);
}

public function progresses()
{
    return $this->progress();
}
 
public function certificates()
{
    return $this->hasMany(Result::class);
}
 


}
