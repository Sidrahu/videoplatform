<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Course;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Storage;

class CourseList extends Component
{
    use WithFileUploads;

    public $courses;
    public $title, $description, $thumbnail;
    public $course_id; // For Edit Mode
    public $isEdit = false;

    public function mount()
    {
        $this->loadCourses();
    }

   public function loadCourses()
{
    $this->courses = Course::with('chapters.videos')->get()->map(function ($course) {
        $progressAvg = UserProgress::where('course_id', $course->id)
            ->avg('progress_percentage');
        $course->progress_avg = round($progressAvg ?? 0);
        return $course;
    });
}


    public function save()
{
    $this->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $thumbnailPath = $this->thumbnail->store('thumbnails', 'public');

    Course::create([
        'title'       => $this->title,
        'description' => $this->description,
        'thumbnail'   => $thumbnailPath,
    ]);

    session()->flash('message', 'Course created successfully!');
    $this->resetForm();
    $this->loadCourses();
}


//     public function edit($id)
// {
//     $course = Course::findOrFail($id);
//     $this->course_id = $course->id;
//     $this->title = $course->title;
//     $this->description = $course->description;
//     $this->isEdit = true;
// }

 

    public function delete($id)
    {
        $course = Course::findOrFail($id);

        if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();
        session()->flash('message', 'Course deleted successfully!');
        $this->loadCourses();
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->thumbnail = null;
        $this->course_id = null;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.admin.course-list')
            ->layout('layouts.app');
    }
}
