<div class="p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Create Chapter</h2>

    @if (session()->has('message'))
        <div class="bg-green-200 p-2 rounded mb-4">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">
        <select wire:model="course_id" class="border p-2 w-full rounded">
            <option value="">Select Course</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
        @error('course_id') <span class="text-red-600">{{ $message }}</span> @enderror

        <input type="text" wire:model="title" placeholder="Chapter Title"
               class="border p-2 w-full rounded">
        @error('title') <span class="text-red-600">{{ $message }}</span> @enderror

        <textarea wire:model="description" placeholder="Chapter Description"
                  class="border p-2 w-full rounded"></textarea>

        <input type="number" wire:model="order" placeholder="Order"
               class="border p-2 w-full rounded">
        @error('order') <span class="text-red-600">{{ $message }}</span> @enderror

        <input type="file" wire:model="resource" class="border p-2 w-full rounded">
        @error('resource') <span class="text-red-600">{{ $message }}</span> @enderror

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
    </form>
</div>
