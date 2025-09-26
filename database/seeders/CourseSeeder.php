<?php

namespace Database\Seeders;
use App\Models\Course;
use Illuminate\Database\Seeder;
 

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'title' => 'Laravel Basics',
            'description' => 'Learn Laravel from scratch.',
            'thumbnail' => 'thumbnails/laravel.png'
        ]);
    }
}
