<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;
use App\Models\Chapter;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $chapters = Chapter::all();

        foreach ($chapters as $chapter) {
            $videos = [
                [
                    'title' => $chapter->title . ' - Part 1',
                    'video_path' => 'videos/demo1.mp4',
                    'duration' => 600 // 10 minutes
                ],
                [
                    'title' => $chapter->title . ' - Part 2',
                    'video_path' => 'videos/demo2.mp4',
                    'duration' => 720 // 12 minutes
                ]
            ];

            foreach ($videos as $video) {
                Video::create([
                    'chapter_id' => $chapter->id,
                    'title' => $video['title'],
                    'video_path' => $video['video_path'],
                    'duration' => $video['duration'],
                ]);
            }
        }
    }
}
