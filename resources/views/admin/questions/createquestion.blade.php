@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📝 Create Question Group</h2>

    <form action="{{ route('admin.questions.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="group_name" class="block text-sm font-medium text-gray-700 mb-1">Group Name</label>
            <input type="text" id="group_name" name="group_name" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Technical Interview" required>
        </div>

        <div id="question-fields">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Question 1</label>
                <input type="text" name="questions[]" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter a question">
            </div>
        </div>

        <button type="button" id="add-question" class="text-blue-600 hover:text-blue-800 text-sm font-medium mb-6 flex items-center gap-1">
            ➕ Add Another Question
        </button>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                 Create Group
            </button>
        </div>
    </form>
</div>

<script>
    let questionCount = 1;

    document.getElementById('add-question').addEventListener('click', function () {
        questionCount++;
        const container = document.createElement('div');
        container.className = 'mb-4';
        container.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 mb-1">Question ${questionCount}</label>
            <input type="text" name="questions[]" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter a question">
        `;
        document.getElementById('question-fields').appendChild(container);
    });
</script>
@endsection
