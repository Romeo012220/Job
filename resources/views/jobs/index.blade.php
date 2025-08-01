@extends('layouts.app')

@section('title', 'Find Jobs')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 bg-white rounded-lg shadow-lg">
    <h1 class="text-4xl font-extrabold mb-8 text-gray-900 tracking-tight font-poppins">
        Available Jobs
    </h1>

    <form method="GET" action="{{ route('jobs.index') }}" class="mb-10">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search for a job by title or keyword..."
            class="w-full px-5 py-3 rounded-xl border border-gray-300 text-base text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition"
            aria-label="Search jobs"
        />
    </form>

    @if(session('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 4000)" 
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
        >
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-5 bg-red-100 text-red-900 rounded-lg shadow-sm font-medium font-roboto">
            {{ session('error') }}
        </div>
    @endif

    @forelse ($jobs as $job)
     <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition duration-300 p-6 mb-6 flex flex-col justify-between min-h-[260px]">
    <div class="mb-4 space-y-2">
      <h2 class="text-2xl font-semibold text-gray-800 capitalize">{{ $job->title }}</h2>


        <p class="text-gray-700 text-base">
            <span class="font-medium text-gray-800">Job Description:</span>
            {{ Str::limit(strip_tags($job->description), 150) }}
        </p>

        <p class="text-gray-700 text-base">
            <span class="font-medium text-gray-800">Educational Requirement:</span>
            {{ $job->education ?? 'Not specified' }}
        </p>
<p class="text-gray-700 text-base flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
    </svg>

    {{ $job->location ?? 'Not specified' }}
</p>


    </div>



            <div class="mt-auto flex flex-wrap gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('jobs.view', $job->id) }}"
                   class="w-28 text-center text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-md transition"
                   title="View full job details">
                    View Job
                </a>



@php
    $alreadyApplied = $job->applications->contains('user_id', Auth::id());
@endphp

@if($job->status === 'open')
    @if($alreadyApplied)
        <span class="w-28 text-sm px-4 py-2 bg-green-100 text-green-800 font-semibold rounded-md text-center">
            ✅ Already Applied
        </span>
    @else
        <button onclick="openModal({{ $job->id }})"
            class="w-28 text-sm px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition text-center"
            title="Apply to this job">
            Apply
        </button>
    @endif
@else
    <span class="w-28 text-sm px-4 py-2 bg-gray-300 text-gray-700 font-semibold rounded-md text-center cursor-not-allowed" title="This job is closed">
        Closed
    </span>
@endif





            </div>
        </div>
    @empty
        <p class="text-gray-600 text-xl font-medium">No jobs found.</p>
    @endforelse
</div>

<!-- Modals -->
@foreach ($jobs as $job)
<div
    id="applyModal-{{ $job->id }}"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-6"
    role="dialog"
    aria-modal="true"
    aria-labelledby="applyModalTitle-{{ $job->id }}"
>
    <div class="bg-white rounded-2xl p-6 w-full max-w-2xl relative shadow-2xl max-h-[90vh] flex flex-col overflow-y-auto">
        <button onclick="closeModal({{ $job->id }})"
                class="absolute top-3 right-4 text-3xl font-bold text-gray-400 hover:text-gray-600"
                title="Close modal">
            &times;
        </button>

        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $job->title }}</h2>
            <p class="text-gray-700"><span class="font-semibold">Location:</span> {{ $job->location }}</p>
            <p class="text-gray-700"><span class="font-semibold">Type:</span> {{ $job->type }}</p>
            @if($job->salary)
                <p class="text-gray-700"><span class="font-semibold">Salary:</span> ₱{{ number_format($job->salary, 2) }}</p>
            @endif
            <p class="text-gray-700 whitespace-pre-line mt-4">
                <span class="font-semibold">Description:</span><br>{{ $job->description }}
            </p>
            <hr class="my-4">
        </div>


        @if(!$job->applications->contains('user_id', Auth::id()))
    <form method="POST" action="{{ route('jobs.apply', $job->id) }}" class="space-y-6">
        @csrf
        <input type="hidden" name="job_id" value="{{ $job->id }}">

        <!-- Name -->
        <div>
            <label class="block font-semibold text-gray-800 mb-2">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ Auth::user()->name }}" readonly required class="w-full border border-gray-300 px-4 py-3 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none bg-gray-100 text-gray-800" />
        </div>

        <!-- Email -->
        <div>
            <label class="block font-semibold text-gray-800 mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ Auth::user()->email }}" readonly required class="w-full border border-gray-300 px-4 py-3 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none bg-gray-100 text-gray-800" />
        </div>

  <!-- Cover Letter -->
<div>
    <label class="block font-semibold text-gray-800 mb-2">Cover Letter</label>
    <textarea name="cover_letter" rows="5" class="w-full border border-gray-300 px-4 py-3 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-800 resize-none" required></textarea>
</div>

        <!-- Additional Questions -->
        @if($job->questionGroup && $job->questionGroup->questions->count())
            <div class="mt-4">
                <h3 class="font-semibold text-lg mb-2">Additional Questions</h3>
           @foreach($job->questionGroup->questions->shuffle()->take(5) as $question)


                    <div class="mb-3">
                        <label class="block text-gray-700 mb-1">{{ $question->question }}</label>
                        <input type="text" name="answers[{{ $question->id }}]" class="w-full border px-3 py-2 rounded focus:ring-blue-500 focus:border-blue-500" required />
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Buttons -->
        <div class="flex justify-end gap-4 mt-6">
            <button type="button" onclick="closeModal({{ $job->id }})" class="px-5 py-2 bg-gray-300 rounded hover:bg-gray-400 transition font-semibold">Cancel</button>
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-semibold shadow-sm">Submit</button>
        </div>
    </form>
@else
    <div class="text-center text-red-600 text-lg font-semibold mt-6">
        You have already applied for this job. ✅
    </div>
    <div class="flex justify-end mt-6">
        <button type="button" onclick="closeModal({{ $job->id }})" class="px-5 py-2 bg-gray-300 rounded hover:bg-gray-400 transition font-semibold">Close</button>
    </div>
@endif
</div> 
</div>
@endforeach

<script>
    function openModal(jobId) {
        const modal = document.getElementById(`applyModal-${jobId}`);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(jobId) {
        const modal = document.getElementById(`applyModal-${jobId}`);
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    window.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            document.querySelectorAll('[id^="applyModal-"]').forEach(modal => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }
    });
</script>
@endsection
