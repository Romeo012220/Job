@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Question</h2>

    <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="question" class="block text-gray-700 font-medium mb-2">Question</label>
            <input type="text" name="question" id="question" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('question', $question->question) }}" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.question-groups.show', $question->question_group_id) }}" class="text-gray-600 hover:underline mr-4">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
        </div>
    </form>
</div>
@endsection
