@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="max-w-5xl mx-auto p-10 bg-white shadow-2xl rounded-3xl mt-12 space-y-10 font-sans">

    <!-- Job Title and Location -->
    <div class="text-center space-y-2">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $job->title }}</h1>
        <p class="text-base text-gray-500">📍 {{ $job->location }}</p>
    </div>

    <!-- Job Details Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

        <!-- Job Category -->
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 text-center">
            <p class="text-sm text-gray-500 mb-1">Job Category</p>
            <p class="text-lg font-semibold text-blue-900">{{ $job->category ?? 'No category' }}</p>
        </div>

        <!-- Education Requirement -->
        <div class="bg-green-50 border border-green-100 rounded-xl p-6 text-center">
            <p class="text-sm text-gray-500 mb-1">Education Requirement</p>
            <p class="text-lg font-semibold text-green-900">{{ $job->education ?? 'Not specified' }}</p>
        </div>

        <!-- Employment Type -->
        <div class="bg-purple-50 border border-purple-100 rounded-xl p-6 text-center">
            <p class="text-sm text-gray-500 mb-1">Employment Type</p>
            <p class="text-lg font-semibold text-purple-900">{{ $job->job_type }}</p>
        </div>

        <!-- Location (again for redundancy clarity) -->
        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-6 text-center col-span-1 md:col-span-3">
            <p class="text-sm text-gray-500 mb-1">Work Location</p>
            <p class="text-lg font-semibold text-yellow-900">{{ $job->location ?? 'Not specified' }}</p>
        </div>

    </div>

    <!-- Job Description -->
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Job Description</h2>
        <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $job->description }}
        </div>
    </div>

    <!-- Qualifications -->
    @if($job->qualifications)
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">🎯 Qualifications</h2>
        <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $job->qualifications }}
        </div>
    </div>
    @endif

    <!-- Apply Button or Closed Message -->
     <!-- Apply Button or Closed Message -->
<div class="text-center pt-4">
    @if($job->status === 'closed')
        <p class="text-lg font-semibold text-red-600">
            ❌ This job is already closed. Applications are no longer accepted.
        </p>
    @elseif($alreadyApplied)
        <p class="text-lg font-semibold text-gray-600">
            ✅ You have already applied for this job.
        </p>
    @else
        <a href="{{ route('jobs.apply', $job->id) }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold py-3 px-8 rounded-xl transition duration-300">
            🚀 Apply Now
        </a>
    @endif
</div>


</div>
@endsection
