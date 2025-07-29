@extends('layouts.app')

@section('title', 'Job Applications')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-white rounded-lg shadow-md">
    <h1 class="text-4xl font-bold mb-8 text-gray-800">Job Applications</h1>

    @if($applications->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-2 text-left">Applicant Name</th>
                        <th class="border px-4 py-2 text-left">Email</th>
                        <th class="border px-4 py-2 text-left">Job Title</th>
                        <th class="border px-4 py-2 text-left">Cover Letter</th>
                        <th class="border px-4 py-2 text-left">Applied At</th>
                        <th class="border px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $application->name }}</td>
                            <td class="border px-4 py-2">{{ $application->email }}</td>
                            <td class="border px-4 py-2">{{ $application->job->title ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ Str::limit($application->cover_letter, 50) }}</td>
                            <td class="border px-4 py-2">
                                {{ $application->created_at->timezone('Asia/Manila')->format('Y-m-d h:i A') }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('admin.applications.show', $application->id) }}"
                                   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @else
        <p class="text-gray-600 text-lg font-medium">No applications found.</p>
    @endif
</div>
@endsection
