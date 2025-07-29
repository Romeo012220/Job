@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">📌Applied Jobs</h1>

    @forelse($applications as $application)
        <div class="mb-6 p-6 bg-white rounded-xl shadow hover:shadow-md transition">
            <h2 class="text-xl font-semibold text-gray-800 mb-1">
                {{ strtoupper($application->job->title) }}
            </h2>
            <p class="text-gray-600 mb-2"><strong>Status:</strong> {{ ucfirst($application->status) }}</p>
            <p class="text-sm text-gray-500">
                <strong>Applied On:</strong> {{ $application->created_at->format('F d, Y') }}
            </p>

            <div class="mt-4">
                <a href="{{ route('applications.show', $application->id) }}"
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    📄 View Application
                </a>
            </div>
        </div>
    @empty
        <div class="text-gray-600 bg-white p-6 rounded-xl shadow text-center">
            You haven't applied to any jobs yet.
        </div>
    @endforelse
</div>
@endsection
