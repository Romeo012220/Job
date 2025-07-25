@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')
<div class="max-w-3xl mx-auto mt-12 bg-white shadow-lg rounded-xl p-8">
    <h2 class="text-3xl font-semibold text-blue-700 mb-8 border-b pb-4">
        ✏️ Edit Job: <span class="text-gray-800">{{ $job->title }}</span>
    </h2>

  <form method="POST" action="{{ route('admin.jobs.update', $job->id) }}">
    @csrf
    @method('PATCH') <!-- ✅ Make sure this is PATCH -->


        <!-- Job Title -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Job Title</label>
            <input type="text" name="title" value="{{ old('title', $job->title) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Job Type -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Type</label>
            <input type="text" name="type" value="{{ old('type', $job->type) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Location -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Location</label>
            <input type="text" name="location" value="{{ old('location', $job->location) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Salary -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Salary</label>
            <input type="number" step="0.01" name="salary" value="{{ old('salary', $job->salary) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" rows="5"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $job->description) }}</textarea>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('admin.jobs.show', $job->id) }}"
                class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg transition">
                ⬅ Cancel
            </a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition shadow">
                💾 Update Job
            </button>
        </div>
    </form>
</div>




@endsection
