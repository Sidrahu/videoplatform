<div class="p-6 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Chapters - {{ $course->title }}</h1>

    @if (session()->has('message'))
        <div class="bg-green-200 p-2 rounded mb-4">{{ session('message') }}</div>
    @endif

    <!-- Add/Edit Chapter Form -->
    <div class="border p-4 rounded bg-white shadow mb-6">
        <h2 class="text-lg font-bold mb-3">{{ $isEdit ? 'Edit Chapter' : 'Add New Chapter' }}</h2>
        <form wire:submit.prevent="save" class="space-y-4 mb-4">
            <input type="text" wire:model="title" placeholder="Chapter Title" class="border p-2 w-full rounded">
            @error('title') <span class="text-red-600">{{ $message }}</span> @enderror

            <textarea wire:model="description" placeholder="Chapter Description"
                      class="border p-2 w-full rounded"></textarea>

            <input type="number" wire:model="order" placeholder="Order" class="border p-2 w-full rounded">

            <input type="file" wire:model="resource" class="border p-2 w-full rounded">
            @error('resource') <span class="text-red-600">{{ $message }}</span> @enderror

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    {{ $isEdit ? 'Update' : 'Add Chapter' }}
                </button>
                @if($isEdit)
                    <button type="button" wire:click="resetForm"
                            class="bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                @endif
            </div>
        </form>
    </div>

    <!-- Existing Chapters -->
    <h2 class="text-xl font-bold mb-3">Existing Chapters</h2>
    @foreach($course->chapters as $chapter)
        <div class="border p-4 mb-4 rounded bg-white shadow">
            <h3 class="font-bold">{{ $chapter->title }} (Order: {{ $chapter->order }})</h3>
            <p>{{ $chapter->description }}</p>
            @if($chapter->resource)
                <a href="{{ asset('storage/' . $chapter->resource) }}" download
                   class="text-blue-600 underline">Download Resource</a>
            @endif
            <div class="mt-2 flex gap-2">
                <button wire:click="edit({{ $chapter->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                <button wire:click="delete({{ $chapter->id }})" onclick="return confirm('Delete this chapter?')"
                        class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                <a href="{{ route('admin.videos', $chapter->id) }}"
                   class="bg-green-600 text-white px-3 py-1 rounded">Manage Videos</a>
            </div>
        </div>
    @endforeach
</div>
