<?php

namespace Database\Seeders;
use Database\Seeders\CourseSeeder;
use App\Models\User;
use Database\Seeders\EnrollmentSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\RoleSeeder; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
    CourseSeeder::class,
     RoleSeeder::class,
     ChapterSeeder::class,
     VideoSeeder::class,
     EnrollmentSeeder::class,

   
]);
   
}
}
