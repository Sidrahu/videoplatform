<div class="p-6 max-w-4xl mx-auto">
    @if(!$isAuthorized)
        <div class="bg-red-200 p-3 rounded">
            Access denied. Enroll in the course to watch this video.
        </div>
        @php $courseId = $video->chapter->course_id ?? null; @endphp
        @if($courseId)
            <a href="{{ route('student.course.show', $courseId) }}"
               class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded">
               Go to Course
            </a>
        @endif
        @php return; @endphp
    @endif

    <h2 class="text-2xl font-bold mb-4">{{ $video->title }}</h2>

    <video id="courseVideo" width="100%" controls>
    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
    Your browser does not support the video tag.
</video>

@if($lastPosition > 0)
    <button 
        onclick="resumeVideo()" 
        class="mt-3 px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">
        Resume from Last Watched ({{ gmdate('i:s', $lastPosition) }})
    </button>
@endif

<div class="mt-4">
    <div class="w-full bg-gray-200 h-2 rounded">
        <div class="bg-green-500 h-2 rounded" style="width: {{ $progress }}%;"></div>
    </div>
    <small>{{ $progress }}% watched</small>
</div>

<script>
    const video = document.getElementById('courseVideo');
    const resumeTime = @json($lastPosition);
    let saveTimer = null;

    function resumeVideo() {
        if (video && resumeTime > 0 && resumeTime < video.duration) {
            video.currentTime = resumeTime;
            video.play();
        }
    }

    video.addEventListener('loadedmetadata', () => {
        if (resumeTime > 0 && resumeTime < video.duration) {
            // Just prepare resume button, don't auto-seek
        }
    });

    video.addEventListener('timeupdate', function () {
        if (video.duration > 0) {
            if (saveTimer) clearTimeout(saveTimer);
            saveTimer = setTimeout(() => {
                let current = Math.floor(video.currentTime);
                let percent = Math.floor((video.currentTime / video.duration) * 100);
                @this.call('saveProgress', current, percent);
            }, 2000);
        }
    });

    video.addEventListener('ended', function () {
        @this.call('saveProgress', Math.floor(video.duration), 100);
    });
</script>
</div>
