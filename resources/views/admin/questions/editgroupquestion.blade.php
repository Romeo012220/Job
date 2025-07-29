@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-6 py-8 bg-white rounded-xl shadow-md space-y-10">

    {{-- Group Header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Edit Group: <span class="text-blue-600">{{ $group->name }}</span></h1>

        <form action="{{ route('admin.questions.update', $group->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium mb-1">Group Name</label>
                <input type="text" name="name" value="{{ old('name', $group->name) }}" 
                       class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                       placeholder="Enter group name">
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md transition">
                Save Group Name
            </button>
        </form>
    </div>

    <hr>

    {{-- Add New Question --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add New Question</h2>

        <form action="{{ route('admin.questions.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="question_group_id" value="{{ $group->id }}">

            <div>
                <label class="block text-gray-700 font-medium mb-1">Question Text</label>
                <textarea name="text" rows="3"
                          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                          placeholder="Enter the question" required></textarea>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md transition">
                Add Question
            </button>
        </form>
    </div>

    <hr>

    {{-- Existing Questions --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Existing Questions</h2>

        @if($group->questions->count())
            <ul class="space-y-3">
                @foreach ($group->questions as $question)
                    <li class="bg-gray-50 border border-gray-200 rounded-md px-4 py-3 flex justify-between items-center space-x-2">
                        <form action="{{ route('admin.questions.updatequestion', $question->id) }}" method="POST" class="flex-1 flex space-x-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="text" value="{{ old('text', $question->text) }}"
                                class="w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                            <button type="submit" class="text-green-600 hover:underline">Save</button>
                        </form>

                        <form action="{{ route('admin.questions.delete', $question->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No questions found in this group yet.</p>
        @endif
    </div>

</div>
@endsection
