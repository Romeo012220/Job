@extends('layouts.app')

@section('title', 'Applicant Details')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 bg-white rounded-2xl shadow-2xl">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center tracking-tight">Applicant Information</h1>

    <div class="space-y-6 text-gray-800 text-[17px] leading-relaxed">
        <div>
            <p class="text-sm text-gray-500 font-medium uppercase">Name</p>
            <p class="text-3xl font-semibold text-indigo-700 tracking-wide">{{ $application->name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 font-medium uppercase">Email</p>
            <p>{{ $application->email }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 font-medium uppercase">Job Title</p>
            <p class="font-medium">{{ $application->job->title ?? 'N/A' }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 font-medium uppercase">Cover Letter</p>
            <div class="p-4 bg-gray-100 border rounded-lg text-gray-700 whitespace-pre-line">
                {{ $application->cover_letter }}
            </div>
        </div>

        <div>
            <p class="text-sm text-gray-500 font-medium uppercase">Resume</p>
            @if ($application->resume_path)
                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                    View Resume
                </a>
            @else
                <span class="text-gray-500 italic">N/A</span>
            @endif
        </div>

        <div>
            <p class="text-sm text-gray-500 font-medium uppercase">Applied At</p>
            <p>{{ $application->created_at->timezone('Asia/Manila')->format('Y-m-d h:i A') }}</p>
        </div>
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('admin.applications.index') }}"
           class="inline-block px-6 py-3 bg-gray-700 text-white font-semibold rounded-lg hover:bg-gray-800 transition">
            ← Back to Applications
        </a>
    </div>
</div>
@endsection
