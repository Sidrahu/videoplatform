<div>
    @if(auth()->check() && auth()->user()->hasRole('admin'))
    <div class="py-10 px-6 md:px-12 max-w-7xl mx-auto bg-gradient-to-b from-slate-50 to-white min-h-screen space-y-10">

        {{-- Header --}}
        <div>
            <h2 class="text-4xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14l6.16-3.422a12.083 12.083 0 01-.537 1.658L12 17.5l-5.623-5.264a12.083 12.083 0 01-.537-1.658L12 14z" />
                </svg>
                Manage Courses
            </h2>
            <p class="text-gray-600 text-lg mt-1">Create, update and manage your platform’s courses with ease.</p>
        </div>

        {{-- Success Message --}}
        @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 px-6 py-4 rounded-md shadow flex items-center gap-3">
            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold">{{ session('message') }}</span>
        </div>
        @endif

        {{-- Course Form --}}
        <div class="bg-white p-8 rounded-xl shadow border border-gray-200 space-y-6">
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'save' }}">
                <div>
                    <label class="block font-medium text-gray-800 mb-1">Course Title</label>
                    <input type="text" wire:model="title" placeholder="e.g. Introduction to Web Development"
                        class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition shadow-sm">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-800 mb-1">Description</label>
                    <textarea wire:model="description" rows="4" placeholder="Course Description..."
                        class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-800 mb-1">Thumbnail</label>
                    <input type="file" wire:model="thumbnail"
                        class="w-full p-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition">
                    @error('thumbnail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow transition font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        {{ $isEdit ? 'Update Course' : 'Create Course' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Course Table --}}
        <div class="bg-white p-6 rounded-xl shadow border border-gray-200 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-800">
                <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3 w-40">Progress</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr class="hover:bg-gray-50 border-b border-gray-200">
                        <td class="px-4 py-4">
                            @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail"
                                class="h-14 w-14 object-cover rounded-md shadow border border-gray-300">
                            @endif
                        </td>
                        <td class="px-4 py-4 font-semibold">{{ $course->title }}</td>
                        <td class="px-4 py-4 text-gray-600">{{ Str::limit($course->description, 80) }}</td>
                        <td class="px-4 py-4">
                            <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden mb-1">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 transition-all"
                                    style="width: {{ $course->progress_avg }}%;"></div>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">{{ $course->progress_avg }}%</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-2 justify-center">

                                {{-- Delete --}}
                                <button wire:click="delete({{ $course->id }})"
                                    onclick="return confirm('Delete this course?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-full flex items-center gap-1 text-sm shadow-sm transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Delete
                                </button>

                                {{-- Chapters --}}
                                <a href="{{ route('admin.chapters', $course->id) }}"
                                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1.5 rounded-full flex items-center gap-1 text-sm shadow-sm transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    Chapters
                                </a>

                                {{-- Progress --}}
                                <a href="{{ route('course.progress', $course->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-full flex items-center gap-1 text-sm shadow-sm transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                    </svg>
                                    Progress
                                </a>

                                {{-- Quizzes --}}
                                <a href="{{ route('admin.quizzes', $course->id) }}"
                                    class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1.5 rounded-full flex items-center gap-1 text-sm shadow-sm transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6l4 2" />
                                    </svg>
                                    Quizzes
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">No courses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    @endif
</div>
