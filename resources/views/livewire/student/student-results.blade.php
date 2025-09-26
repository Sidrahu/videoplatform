<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">📊 My Quiz Results</h2>

    @if($results->count() > 0)
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">📘 Quiz Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">✅ Score</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">📅 Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($results as $result)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $result->quiz->title }}</td>
                            <td class="px-6 py-4 text-green-600 font-semibold">{{ $result->score }}%</td>
                            <td class="px-6 py-4 text-gray-600">{{ $result->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-gray-600 mt-4">You have not taken any quizzes yet.</div>
    @endif
</div>
