<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;
use App\Models\Course;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        // Pehle ek course le lo (seeded from CourseSeeder)
        $course = Course::first();

        if ($course) {
            $chapters = [
                ['title' => 'Introduction to Laravel', 'description' => 'Basic overview of Laravel framework.', 'order' => 1],
                ['title' => 'Routing Basics', 'description' => 'Understanding Laravel routing system.', 'order' => 2],
                ['title' => 'Controllers & Views', 'description' => 'Learn controllers and blade templates.', 'order' => 3],
                ['title' => 'Database & Migrations', 'description' => 'Learn about Eloquent ORM and migrations.', 'order' => 4],
                ['title' => 'Authentication', 'description' => 'User login and registration setup.', 'order' => 5],
            ];

            foreach ($chapters as $chapter) {
                Chapter::create([
                    'course_id'   => $course->id,
                    'title'       => $chapter['title'],
                    'description' => $chapter['description'],
                    'order'       => $chapter['order'],
                ]);
            }
        }
    }
}
