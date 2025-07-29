@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Question</h2>

        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Question</label>
                <input type="text" name="question" value="{{ $question->question }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection
