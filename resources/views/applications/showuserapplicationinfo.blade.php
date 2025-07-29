@extends('layouts.app')

@section('title', 'My Application Details')

@section('content')
<div class="max-w-4xl mx-auto mt-12 bg-white shadow-xl rounded-2xl p-8 space-y-8">

    <div class="border-b pb-6">
        <h2 class="text-3xl font-extrabold text-blue-700 flex items-center gap-2">
            📄 Application for:
            <span class="text-gray-800">{{ $application->job->title }}</span>
        </h2>
        <p class="mt-2 text-sm text-gray-500">Submitted by {{ $application->name }} | {{ $application->email }}</p>
    </div>

    {{-- Job Information --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700 text-lg">
        @if($application->job->category)
            <div class="flex items-start gap-2">
                <span class="text-blue-600">📁</span>
                <p><strong>Category:</strong> {{ $application->job->category }}</p>
            </div>
        @endif

        @if($application->job->education)
            <div class="flex items-start gap-2">
                <span class="text-blue-600">🎓</span>
                <p><strong>Education:</strong> {{ $application->job->education }}</p>
            </div>
        @endif

        @if($application->job->employment_type)
            <div class="flex items-start gap-2">
                <span class="text-blue-600">💼</span>
                <p><strong>Employment Type:</strong> {{ $application->job->employment_type }}</p>
            </div>
        @endif

        @if($application->job->location)
            <div class="flex items-start gap-2">
                <span class="text-blue-600">📍</span>
                <p><strong>Location:</strong> {{ $application->job->location }}</p>
            </div>
        @endif
    </div>



  {{-- Job Description --}}
    @if($application->job->description)
        <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">🧾 Job Description</h3>
            <div class="bg-gray-50 border-l-4 border-gray-500 p-4 rounded-lg text-gray-800">
                {!! nl2br(e($application->job->description)) !!}
            </div>
        </div>
    @endif

    {{-- Qualifications --}}
    @if($application->job->qualifications)
        <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">✅ Qualifications</h3>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg text-gray-800">
                {!! nl2br(e($application->job->qualifications)) !!}
            </div>
        </div>
    @endif

  

    {{-- Cover Letter --}}
    @if ($application->cover_letter)
        <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2"> Cover Letter</h3>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg text-gray-800 whitespace-pre-line">
                {{ $application->cover_letter }}
            </div>
        </div>
    @endif

    {{-- Resume --}}
    @if ($application->resume_path)
        <div class="text-lg">
            <strong class="text-gray-800">📎 Resume:</strong>
            <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="text-blue-600 underline ml-1">View Resume</a>
        </div>
    @endif

    {{-- Divider --}}
    <hr class="my-8 border-gray-300">

    {{-- Answers to Questions --}}
    <div>
        <h3 class="text-2xl font-bold text-gray-800 mb-4">📝 Your Answers</h3>
        <ul class="space-y-4">
               @forelse ($application->answers as $answer)
                <li class="bg-gray-100 p-5 rounded-xl shadow-sm">
                    <p class="font-medium text-gray-900 mb-2">❓ Question:
                        <span class="text-gray-700">{{ $answer->question->question ?? 'Question not found' }}</span>
                    </p>
                    <p class="text-gray-800"><strong>Answer:</strong> {{ $answer->answer }}</p>
                </li>
            @empty
                <li class="text-gray-600">No answers submitted.</li>
            @endforelse
        </ul>
    </div>

</div>
@endsection
