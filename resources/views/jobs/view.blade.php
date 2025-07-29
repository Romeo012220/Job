@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="max-w-4xl mx-auto p-8 bg-white shadow-xl rounded-2xl mt-10 space-y-8">

    <!-- Header -->
    <div class="text-center space-y-1">
        <h1 class="text-4xl font-extrabold text-gray-800">{{ $job->title }}</h1>
        <p class="text-gray-500">📍 {{ $job->location }}</p>
    </div>

    <!-- Meta Grid -->

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <!-- Job Category -->
    <div class="bg-blue-50 rounded-lg p-5 border border-blue-100 text-center">
        <p class="text-sm text-gray-500">Job Category</p>
     <p class="text-lg font-semibold text-blue-900">{{ $job->category ?? 'No category' }}
</p>

    </div>

    <!-- Education Requirement -->
    <div class="bg-green-50 rounded-lg p-5 border border-green-100 text-center">
        <p class="text-sm text-gray-500">Education Requirement</p>
        <p class="text-lg font-semibold text-green-900">{{ $job->education }}</p>
    </div>

    <!-- Employment Type -->
    <div class="bg-purple-50 rounded-lg p-5 border border-purple-100 text-center">
        <p class="text-sm text-gray-500">Employment Type</p>
        <p class="text-lg font-semibold text-purple-900">{{ $job->job_type }}</p>
    </div>
</div>

    <!-- Description -->
    <div>
        <h2 class="text-2xl font-bold text-gray-700 mb-3">📝 Job Description</h2>
        <div class="text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50 p-4 rounded-lg border border-gray-100">
            {{ $job->description }}
        </div>
    </div>

    <!-- Qualifications -->
    @if($job->qualifications)
    <div>
        <h2 class="text-2xl font-bold text-gray-700 mb-3">🎯 Qualifications</h2>
        <div class="text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50 p-4 rounded-lg border border-gray-100">
            {{ $job->qualifications }}
        </div>
    </div>
    @endif

    <!-- Apply Button or Closed Message -->
    <div class="text-center mt-8">
        @if($job->status === 'closed')
            <p class="text-red-600 font-semibold text-lg">
                ❌ This job is already closed. Applications are no longer accepted.
            </p>
        @else
            <a href="{{ route('jobs.apply', $job->id) }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg py-3 px-6 rounded-lg transition duration-300">
                🚀 Apply Now
            </a>
        @endif
    </div>

</div>
@endsection
