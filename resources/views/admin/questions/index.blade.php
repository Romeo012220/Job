@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">🧠 Question Groups</h1>
        <a href="{{ route('admin.questions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-5 rounded-lg shadow-md transition">
            + Create Group
        </a>
    </div>

    @forelse ($groups->sortByDesc('created_at') as $group)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $group->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Created on {{ $group->created_at->format('F j, Y') }}</p>
                    <div class="mt-3">
                        <a href="{{ route('admin.question-groups.show', $group->id) }}" class="text-blue-600 hover:underline font-medium text-sm">
                            📋 View Questions
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.questions.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:text-red-800 font-medium text-sm hover:underline">
                        🗑️ Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded shadow text-sm">
            ⚠️ No question groups found.
        </div>
    @endforelse
</div>
@endsection
