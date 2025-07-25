@extends('layouts.app')

@section('title', 'Job Details')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">

        {{-- Title --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-gray-800 border-b pb-2">Job Title: {{ $job->title }}</h2>
            <a href="{{ route('admin.jobs.edit', $job->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600 transition">
                ✏️ Edit
            </a>
        </div>

        {{-- Job Info --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Job Type</p>
                <p class="text-lg text-gray-900">{{ $job->type }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Location</p>
                <p class="text-lg text-gray-900">{{ $job->location }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-1">Salary</p>
                <p class="text-lg text-gray-900">₱{{ number_format($job->salary, 2) }}</p>
            </div>
        </div>

        {{-- Description --}}
        <div class="mb-6">
            <p class="text-gray-600 text-sm font-semibold mb-1">Job Description</p>
            <div class="prose max-w-none text-gray-800">
                {!! nl2br(e($job->description)) !!}
            </div>
        </div>

        {{-- Back Link --}}
        <div class="text-left">
            <a href="{{ route('admin.jobs.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition">
                ← Back to all jobs
            </a>
        </div>
    </div>
</div>
@endsection
