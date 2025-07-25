@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">My Applications</h1>

    @forelse($applications as $application)
        <div class="mb-4 p-4 bg-white rounded shadow">
            <h2 class="font-semibold text-lg">{{ $application->job->title }}</h2>
            <p>Status: {{ $application->status }}</p>
        </div>
    @empty
        <p class="text-gray-600">You haven't applied to any jobs yet.</p>
    @endforelse
@endsection
