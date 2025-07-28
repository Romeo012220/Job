@extends('layouts.app')

@section('title', 'Applicant Details')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 bg-white rounded-3xl shadow-2xl">
    <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-10 tracking-tight">Applicant Profile</h1>

    {{-- Basic Information --}}
    <div class="space-y-6 text-[17px] text-gray-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase">Name</p>
                <p class="text-2xl font-semibold text-indigo-700">{{ $application->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium uppercase">Email</p>
                <p class="text-gray-800">{{ $application->email }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium uppercase">Job Title</p>
                <p class="text-gray-800 font-medium">{{ $application->job->title ?? 'N/A' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 font-medium uppercase">Applied At</p>
                <p class="text-gray-800">{{ $application->created_at->timezone('Asia/Manila')->format('Y-m-d h:i A') }}</p>
            </div>
        </div>

        {{-- Cover Letter --}}
        <div>
            <p class="text-sm text-gray-500 font-medium uppercase">Cover Letter</p>
            <div class="mt-2 p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 whitespace-pre-line leading-relaxed shadow-sm">
                {{ $application->cover_letter }}
            </div>
        </div>

        {{-- Resume --}}
        <div>
            <p class="text-sm text-gray-500 font-medium uppercase">Resume</p>
            @if ($application->resume_path)
                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
                   class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">
                    📄 View Resume
                </a>
            @else
                <span class="text-gray-500 italic">No resume provided</span>
            @endif
        </div>
    </div>

    {{-- Answers to Questions --}}
    @if($application->answers->count())
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Applicant Answers</h2>

        <div class="space-y-5">
            @foreach ($application->answers as $answer)
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 shadow-sm">
                    <p class="text-lg font-medium text-gray-900">{{ $answer->question->question ?? 'Question not found' }}</p>
                    <p class="mt-2 text-gray-700">{{ $answer->answer ?? 'No answer provided' }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Back Button --}}
    <div class="mt-10 text-center">
        <a href="{{ route('admin.applications.index') }}"
           class="inline-block px-6 py-3 bg-gray-700 text-white font-semibold rounded-lg hover:bg-gray-800 transition">
            ← Back to Applications
        </a>
    </div>
</div>
@endsection
