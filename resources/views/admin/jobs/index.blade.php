@extends('layouts.app')

@section('title', 'Admin - Job Listings')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Admin - All Job Posts</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white shadow border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-4 border-b">Title</th>
                <th class="py-2 px-4 border-b">Type</th>
                <th class="py-2 px-4 border-b">Location</th>
                <th class="py-2 px-4 border-b">Salary</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $job->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $job->type }}</td>
                    <td class="py-2 px-4 border-b">{{ $job->location }}</td>
                    <td class="py-2 px-4 border-b">₱{{ number_format($job->salary, 2) }}</td>
                    <td class="py-2 px-4 border-b">
                        <!-- Add edit/delete links later if needed -->
<a href="{{ route('jobs.show', $job->id) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">No jobs posted yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</div>
@endsection
