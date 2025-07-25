@extends('layouts.app')

@section('title', 'My Job Applications')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">My Job Applications</h1>

    @if ($applications->isEmpty())
        <p>You have not applied to any jobs yet.</p>
    @else
        @foreach ($applications as $application)
            <div class="bg-white p-4 shadow mb-4 rounded">
                <h2 class="text-xl font-semibold">{{ $application->job->title ?? 'Job Deleted' }}</h2>
                <p class="text-gray-600">{{ $application->job->description ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $application->job->location ?? '' }} | {{ $application->job->type ?? '' }}</p>

                <p class="mt-2"><strong>Applied on:</strong> {{ $application->created_at->format('M d, Y') }}</p>
                <p><strong>Cover Letter:</strong> {{ $application->cover_letter ?: 'N/A' }}</p>

                <p>
                    <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="text-blue-600 underline">
                        View Resume
                    </a>
                </p>
            </div>
        @endforeach
    @endif
</div>
@endsection
