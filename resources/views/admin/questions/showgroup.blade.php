@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">{{ $group->name }}</h2>

    <ul class="space-y-4">
        @foreach ($group->questions as $question)
            <li class="flex justify-between items-center border-b pb-2">
                <div class="text-gray-700">{{ $question->question }}</div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.questions.edit', $question->id) }}"
                       class="text-blue-600 hover:underline text-sm">
                        Edit
                    </a>
                    <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="mt-6">
        <a href="{{ route('admin.questions.create', ['group_id' => $group->id]) }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded">
            + Add New Question
        </a>
    </div>
</div>
@endsection
