<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Chapter;
use App\Models\Course;

class ChapterCreate extends Component
{
    use WithFileUploads;

    public $course;
    public $chapters;
    public $title, $description, $order = 1, $resource;
    public $chapter_id;
    public $isEdit = false;

    public function mount($courseId)
    {
        $this->course = Course::findOrFail($courseId);
        $this->loadChapters();
    }

    public function loadChapters()
    {
        $this->chapters = Chapter::where('course_id', $this->course->id)
            ->orderBy('order')
            ->get();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'integer|min:1',
            'resource' => 'nullable|mimes:pdf,zip|max:10240',
        ]);

        $path = $this->resource ? $this->resource->store('resources', 'public') : null;

        if ($this->isEdit) {
            $chapter = Chapter::findOrFail($this->chapter_id);
            $chapter->update([
                'title' => $this->title,
                'description' => $this->description,
                'order' => $this->order,
                'resource' => $path ?? $chapter->resource,
            ]);
            session()->flash('message', 'Chapter updated successfully!');
        } else {
            Chapter::create([
                'course_id' => $this->course->id,
                'title' => $this->title,
                'description' => $this->description,
                'order' => $this->order,
                'resource' => $path,
            ]);
            session()->flash('message', 'Chapter created successfully!');
        }

        $this->resetForm();
        $this->loadChapters();
    }

    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);
        $this->chapter_id = $chapter->id;
        $this->title = $chapter->title;
        $this->description = $chapter->description;
        $this->order = $chapter->order;
        $this->isEdit = true;
    }

    public function delete($id)
    {
        Chapter::destroy($id);
        session()->flash('message', 'Chapter deleted successfully!');
        $this->loadChapters();
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->order = 1;
        $this->resource = null;
        $this->chapter_id = null;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.admin.chapter-manage')
            ->layout('layouts.app');
    }
}
