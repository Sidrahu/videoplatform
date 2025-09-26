<?php

namespace App\Models;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['chapter_id', 'title', 'video_path', 'duration'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
