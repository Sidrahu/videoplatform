<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Video;
use App\Models\Chapter;
use Illuminate\Support\Facades\Storage;

class VideoUpload extends Component
{
    use WithFileUploads;

    public $chapter;
    public $title, $video_file;

    public function mount($chapterId)
    {
        $this->chapter = Chapter::findOrFail($chapterId);
    }

    public function save()
    {
        $this->validate([
            'title'      => 'required|string|max:255',
            'video_file' => 'required|mimes:mp4,mov,avi|max:51200', // max 50MB
        ]);

        // Save the video file
        $path = $this->video_file->store('videos', 'public');

        // Save record in database
        Video::create([
            'chapter_id' => $this->chapter->id,
            'title'      => $this->title,
            'video_path' => $path,
            'duration'   => 0, // You can calculate actual duration if needed
        ]);

        session()->flash('message', 'Video uploaded successfully!');
        $this->reset(['title', 'video_file']);
    }

    public function render()
    {
        return view('livewire.admin.video-upload')
            ->layout('layouts.app');
    }
}
