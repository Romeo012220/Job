@extends('layouts.app')

@section('title', 'Job Applications')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-white rounded-lg shadow-lg">
    <h1 class="text-4xl font-extrabold mb-8 text-gray-900 tracking-tight">Job Applications</h1>

    @if($applications->count())
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="border border-gray-300 px-4 py-2 text-left">Applicant Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Job Title</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Cover Letter</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Resume</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Applied At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $application->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $application->email }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $application->job->title ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ Str::limit($application->cover_letter, 50) }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if($application->resume_path)
                                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="text-blue-600 underline">View Resume</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $application->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @else
        <p class="text-gray-600 text-xl font-medium">No applications found.</p>
    @endif
</div>
@endsection
