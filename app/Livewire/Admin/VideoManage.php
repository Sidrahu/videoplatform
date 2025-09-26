<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Video;
use App\Models\Chapter;
use Illuminate\Support\Facades\Storage;

class VideoManage extends Component
{
    use WithFileUploads;

    public $chapter;
    public $title, $video_file, $videoId;
    public $isEdit = false;

    public function mount($chapterId)
    {
        $this->chapter = Chapter::with('videos')->findOrFail($chapterId);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'video_file' => $this->isEdit ? 'nullable|mimes:mp4,mov,avi|max:50000' : 'required|mimes:mp4,mov,avi|max:50000',
        ]);

        $path = $this->video_file ? $this->video_file->store('videos', 'public') : null;

        if ($this->isEdit) {
            $video = Video::findOrFail($this->videoId);
            $video->update([
                'title' => $this->title,
                'video_path' => $path ?? $video->video_path,
            ]);
            session()->flash('message', 'Video updated successfully!');
        } else {
            Video::create([
                'chapter_id' => $this->chapter->id,
                'title'      => $this->title,
                'video_path' => $path,
                'duration'   => 0,
            ]);
            session()->flash('message', 'Video uploaded successfully!');
        }

        $this->resetForm();
        $this->chapter->refresh();
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $this->videoId = $video->id;
        $this->title = $video->title;
        $this->isEdit = true;
    }

    public function delete($id)
    {
        $video = Video::findOrFail($id);
        if ($video->video_path && Storage::disk('public')->exists($video->video_path)) {
            Storage::disk('public')->delete($video->video_path);
        }
        $video->delete();
        session()->flash('message', 'Video deleted successfully!');
        $this->chapter->refresh();
    }

    public function resetForm()
    {
        $this->title = '';
        $this->video_file = null;
        $this->videoId = null;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.admin.video-manage')
            ->layout('layouts.app');
    }
}
