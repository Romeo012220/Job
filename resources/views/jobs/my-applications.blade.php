@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">My Job Applications</h1>

    @forelse($applications as $app)
        <div class="bg-white p-4 shadow rounded mb-4">
            <h2 class="text-xl font-semibold">{{ $app->job->title }}</h2>
            <p><strong>Location:</strong> {{ $app->job->location }}</p>
            <p><strong>Applied at:</strong> {{ $app->created_at->format('M d, Y H:i') }}</p>
            @if($app->cover_letter)
                <p><strong>Cover Letter:</strong> {{ $app->cover_letter }}</p>
            @endif
        </div>
    @empty
        <p class="text-gray-600">You haven’t applied to any jobs yet.</p>
    @endforelse
</div>
@endsection
