<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Chapter;
use App\Models\Course;

class ChapterManage extends Component
{
    use WithFileUploads;

    public $course, $title, $description, $order = 1, $chapterId;
    public $isEdit = false;
    public $resource; // PDF/Resource file

    public function mount($courseId)
    {
        $this->course = Course::with('chapters')->findOrFail($courseId);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|numeric',
            'resource' => 'nullable|mimes:pdf,docx,zip|max:20480', // 20 MB max
        ]);

        $resourcePath = null;
        if ($this->resource) {
            $resourcePath = $this->resource->store('chapters/resources', 'public');
        }

        Chapter::create([
            'course_id'   => $this->course->id,
            'title'       => $this->title,
            'description' => $this->description,
            'order'       => $this->order,
            'resource'    => $resourcePath,
        ]);

        session()->flash('message', 'Chapter created successfully!');
        $this->resetForm();
        $this->reloadCourse();
    }

    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);
        $this->chapterId   = $chapter->id;
        $this->title       = $chapter->title;
        $this->description = $chapter->description;
        $this->order       = $chapter->order;
        $this->isEdit      = true;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|numeric',
            'resource' => 'nullable|mimes:pdf,docx,zip|max:20480',
        ]);

        $chapter = Chapter::findOrFail($this->chapterId);

        $resourcePath = $chapter->resource;
        if ($this->resource) {
            $resourcePath = $this->resource->store('chapters/resources', 'public');
        }

        $chapter->update([
            'title'       => $this->title,
            'description' => $this->description,
            'order'       => $this->order,
            'resource'    => $resourcePath,
        ]);

        session()->flash('message', 'Chapter updated successfully!');
        $this->resetForm();
        $this->reloadCourse();
    }

    public function delete($id)
    {
        Chapter::destroy($id);
        session()->flash('message', 'Chapter deleted successfully!');
        $this->reloadCourse();
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'order', 'chapterId', 'resource']);
        $this->order = 1;
        $this->isEdit = false;
    }

    private function reloadCourse()
    {
        $this->course = Course::with('chapters')->find($this->course->id);
    }

    public function render()
    {
        return view('livewire.admin.chapter-manage')->layout('layouts.app');
    }
}
