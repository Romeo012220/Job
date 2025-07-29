@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Question Groups</h1>
        <a href="{{ route('admin.questions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
            + Create New Group
        </a>
    </div>

    @forelse ($groups as $group)
        <div class="bg-white shadow-md rounded-lg p-6 mb-5 hover:shadow-lg transition">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $group->name }}</h2>
                    <div class="mt-2 space-x-4">
                      <a href="{{ route('admin.question-groups.show', $group->id) }}">📋 View Questions</a>
                      
                    </div>
                </div>
                <form action="{{ route('admin.questions.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:text-red-800 font-medium hover:underline">🗑️ Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded shadow">
            No question groups found.
        </div>
    @endforelse
</div>
@endsection
