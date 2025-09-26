<div>
   <div class="p-6 max-w-4xl mx-auto text-center">
    <h2 class="text-2xl font-bold mb-4">Certificate for {{ $result->quiz->title }}</h2>
    <p class="mb-4">You scored {{ $result->score }}/{{ $result->quiz->questions->count() }}.</p>

    <button wire:click="downloadCertificate"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Download Certificate (PDF)
    </button>
</div>

</div>
