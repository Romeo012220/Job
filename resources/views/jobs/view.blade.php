@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="max-w-4xl mx-auto p-8 bg-white shadow-md rounded-2xl mt-8 space-y-6">

    <!-- Job Title -->
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800">{{ $job->title }}</h1>
        <p class="text-sm text-gray-500 mt-1">Posted Location: <span class="font-medium text-gray-700">{{ $job->location }}</span></p>
    </div>

    <!-- Job Meta Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
            <p class="text-gray-500">Job Type</p>
            <p class="text-gray-800 font-semibold">{{ $job->type }}</p>
        </div>
      
        
    </div>

    <!-- Job Description -->
    <div>
        <h2 class="text-xl font-bold text-gray-700 mb-2">Job Description</h2>
        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $job->description }}</p>
    </div>

    <!-- Application Questions -->
 

    <!-- Apply Button -->
   <div class="mt-6">
    @if($job->status === 'closed')
        <p class="text-red-600 font-semibold">This job is already closed. Applications are no longer accepted.</p>
    @else
        <a href="{{ route('jobs.apply', $job->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            Apply Now
        </a>
    @endif
</div>


</div>
@endsection
