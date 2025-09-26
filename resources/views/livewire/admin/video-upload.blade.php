<div class="max-w-xl mx-auto p-6 bg-white rounded-2xl shadow-xl border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <svg class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15.75 10.5L19.5 12l-3.75 1.5M4.5 19.5v-15A1.5 1.5 0 016 3h12a1.5 1.5 0 011.5 1.5v15a1.5 1.5 0 01-1.5 1.5H6a1.5 1.5 0 01-1.5-1.5z"/>
        </svg>
        <span class="tracking-tight">Upload Lecture Video</span>
    </h2>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Video Title --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Video Title</label>
            <input wire:model="title" type="text"
                   placeholder="e.g., Introduction to HTML"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition">
            @error('title') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Select Chapter --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Chapter</label>
            <select wire:model="chapter_id"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition">
                <option value="">-- Select Chapter --</option>
                @foreach($chapters as $chapter)
                    <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                @endforeach
            </select>
            @error('chapter_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Video File --}}
        {{-- Video File --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Video File</label>
    <input type="file" wire:model="video_file"
           accept="video/mp4,video/x-m4v,video/*"
           class="w-full text-sm text-gray-700 file:px-4 file:py-2 file:rounded-lg file:border-0 file:text-white file:bg-blue-600 hover:file:bg-blue-700 transition file:cursor-pointer">
    @error('video_file') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

    <p class="text-xs text-gray-500 mt-1">
        🔻 Recommended: Keep video size under <span class="font-semibold text-gray-800">80MB</span> <br>
        Use <a href="https://www.veed.io/compress-video" target="_blank" class="underline text-blue-600">Veed.io</a> or
        <a href="https://handbrake.fr" target="_blank" class="underline text-blue-600">HandBrake</a> (Free) to reduce size before uploading.
    </p>
</div>

        {{-- Submit --}}
        <div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a1 1 0 001 1h3m10-2a1 1 0 001-1v-1m-1 4a1 1 0 001-1v-1m-3-3v4a1 1 0 001 1m-3-4v4a1 1 0 001 1m-3-4v4a1 1 0 001 1m-3-4v4a1 1 0 001 1m-3-4v4a1 1 0 001 1M4 16v-1a1 1 0 011-1h14a1 1 0 011 1v1"/>
                </svg>
                Upload Video
            </button>
        </div>
    </form>
</div>
