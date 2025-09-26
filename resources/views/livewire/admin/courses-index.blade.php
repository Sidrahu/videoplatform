<div>
   <div class="p-6 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Courses</h1>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2 border">#</th>
                <th class="p-2 border">Title</th>
                <th class="p-2 border">Enrolled</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td class="p-2 border">{{ $course->id }}</td>
                    <td class="p-2 border font-semibold">{{ $course->title }}</td>
                    <td class="p-2 border">{{ $course->enrollments_count }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.course.progress', $course->id) }}"
                           class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                           View Progress
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-4 text-center text-gray-500">No courses found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>
