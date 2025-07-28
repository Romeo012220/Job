@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Create Question Group</h2>

    <form action="{{ route('admin.questions.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Group Name</label>
            <input type="text" name="group_name" class="w-full border p-2 rounded" required>
        </div>

        <div id="question-fields">
            <div class="mb-4">
                <label class="block font-semibold mb-1">Question 1</label>
                <input type="text" name="questions[]" class="w-full border p-2 rounded">
            </div>
        </div>

        <button type="button" id="add-question" class="bg-gray-200 text-sm px-3 py-1 rounded mb-4">+ Add Another Question</button>

        <div class="text-right">
            <button class="bg-green-600 text-white px-4 py-2 rounded">Create Group</button>
        </div>
    </form>
</div>

<script>
document.getElementById('add-question').addEventListener('click', function () {
    const count = document.querySelectorAll('#question-fields input').length + 1;
    const container = document.createElement('div');
    container.className = 'mb-4';
    container.innerHTML = `
        <label class="block font-semibold mb-1">Question ${count}</label>
        <input type="text" name="questions[]" class="w-full border p-2 rounded">
    `;
    document.getElementById('question-fields').appendChild(container);
});
</script>
@endsection
