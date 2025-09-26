<div class="p-6 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Videos - {{ $chapter->title }}</h1>

    @if (session()->has('message'))
        <div class="bg-green-200 p-2 rounded mb-4">{{ session('message') }}</div>
    @endif

    <!-- Add/Edit Video -->
    <div class="border p-4 rounded bg-white shadow mb-6">
        <h2 class="text-lg font-bold mb-3">{{ $isEdit ? 'Edit Video' : 'Upload New Video' }}</h2>
        <form wire:submit.prevent="save" class="space-y-4 mb-4">
            <input type="text" wire:model="title" placeholder="Video Title" class="border p-2 w-full rounded">
            @error('title') <span class="text-red-600">{{ $message }}</span> @enderror

            <input type="file" wire:model="video_file" class="border p-2 w-full rounded">
            @error('video_file') <span class="text-red-600">{{ $message }}</span> @enderror

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    {{ $isEdit ? 'Update Video' : 'Upload Video' }}
                </button>
                @if($isEdit)
                    <button type="button" wire:click="resetForm"
                            class="bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                @endif
            </div>
        </form>
    </div>

    <!-- Existing Videos -->
    <h2 class="text-xl font-bold mb-3">Existing Videos</h2>
    @foreach($chapter->videos as $video)
        <div class="border p-4 mb-4 rounded bg-white shadow">
            <h3 class="font-bold">{{ $video->title }}</h3>
            <video width="100%" controls>
                <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="mt-2 flex gap-2">
                <button wire:click="edit({{ $video->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                <button wire:click="delete({{ $video->id }})" onclick="return confirm('Delete this video?')"
                        class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    @endforeach
</div>
