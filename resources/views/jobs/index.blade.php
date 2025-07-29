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
            placeholder="Search jobs..."
            class="w-full p-4 rounded-lg border border-gray-300 text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-3 focus:ring-blue-500 focus:border-blue-500 font-roboto"
            aria-label="Search jobs"
        >
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
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $job->title }}</h2>
            <p class="text-gray-600 text-sm leading-relaxed">{{ Str::limit(strip_tags($job->description), 150) }}</p>
        </div>

        <div class="mt-auto flex flex-wrap gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('jobs.view', $job->id) }}"
               class="w-28 text-center text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-md transition"
               title="View full job details">
                View Job
            </a>

            @if($job->status === 'open')
                <button onclick="openModal({{ $job->id }})"
                        class="w-28 text-sm px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition text-center"
                        title="Apply to this job">
                    Apply
                </button>
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
    <div class="bg-white rounded-xl p-6 w-full max-w-lg relative shadow-2xl max-h-[550px] flex flex-col overflow-y-auto">
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

        <form method="POST" action="{{ route('jobs.apply', $job->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="job_id" value="{{ $job->id }}">

            <div>
                <label class="block font-semibold text-gray-800 mb-2">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label class="block font-semibold text-gray-800 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label class="block font-semibold text-gray-800 mb-2">Cover Letter</label>
                <textarea name="cover_letter" rows="5" class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div>
                <label class="block font-semibold text-gray-800 mb-2">Upload Resume <span class="text-red-500">*</span></label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx" required class="w-full border rounded px-3 py-2" />
            </div>

            @if($job->questionGroup && $job->questionGroup->questions->count())
                <div class="mt-4">
                    <h3 class="font-semibold text-lg mb-2">Additional Questions</h3>
                    @foreach($job->questionGroup->questions as $question)
                        <div class="mb-3">
                            <label class="block text-gray-700 mb-1">{{ $question->question }}</label>
                            <input type="text" name="answers[{{ $question->id }}]" class="w-full border px-3 py-2 rounded focus:ring-blue-500 focus:border-blue-500" required />
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeModal({{ $job->id }})" class="px-5 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit</button>
            </div>
        </form>
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

    // Close modal on ESC
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
