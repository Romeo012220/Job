@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')
<div class="max-w-3xl mx-auto mt-12 bg-white shadow-lg rounded-xl p-8">
    <h2 class="text-3xl font-semibold text-blue-700 mb-8 border-b pb-4">
        ✏️ Edit Job: <span class="text-gray-800">{{ $job->title }}</span>
    </h2>

    <form method="POST" action="{{ route('admin.jobs.update', $job->id) }}">
        @csrf
        @method('PATCH')

        <!-- Job Title -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Job Title</label>
            <input type="text" name="title" value="{{ old('title', $job->title) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Job Category (Type) -->
        <div class="mt-4">
            <label class="block text-gray-700 font-medium mb-1">Job Category</label>
            <select name="type" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select Category --</option>
                <option value="IT" {{ old('type', $job->type) == 'IT' ? 'selected' : '' }}>IT</option>
                <option value="Sales" {{ old('type', $job->type) == 'Sales' ? 'selected' : '' }}>Sales</option>
                <option value="Finance" {{ old('type', $job->type) == 'Finance' ? 'selected' : '' }}>Finance</option>
                <option value="HR" {{ old('type', $job->type) == 'HR' ? 'selected' : '' }}>HR</option>
                <option value="Others" {{ old('type', $job->type) == 'Others' ? 'selected' : '' }}>Others</option>
            </select>
        </div>

        <!-- Education -->
        <div class="mt-4">
            <label class="block text-gray-700 font-medium mb-1">Education</label>
            <select name="education" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select Education --</option>
                <option value="Bachelors" {{ old('education', $job->education) == 'Bachelors' ? 'selected' : '' }}>Bachelors</option>
                <option value="Vocational" {{ old('education', $job->education) == 'Vocational' ? 'selected' : '' }}>Vocational</option>
                <option value="Others" {{ old('education', $job->education) == 'Others' ? 'selected' : '' }}>Others</option>
            </select>
        </div>

        <!-- Job Type -->
        <div class="mt-4">
            <label class="block text-gray-700 font-medium mb-1">Job Type</label>
            <select name="job_type" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select Job Type --</option>
                <option value="Full-Time" {{ old('job_type', $job->job_type) == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                <option value="Part-Time" {{ old('job_type', $job->job_type) == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
            </select>
        </div>

        <!-- Qualifications -->
        <div class="mt-4">
            <label class="block text-gray-700 font-medium mb-1">Qualifications</label>
            <textarea name="qualifications" rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('qualifications', $job->qualifications) }}</textarea>
        </div>

        <!-- Location -->
        <div class="mt-4">
            <label class="block text-gray-700 font-medium mb-1">Location</label>
            <input type="text" name="location" value="{{ old('location', $job->location) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Description -->
        <div class="mt-4">
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
