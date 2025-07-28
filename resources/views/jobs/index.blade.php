@extends('layouts.app')

@section('title', 'Find Jobs')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 bg-white rounded-lg shadow-lg">
    <h1 class="text-4xl font-extrabold mb-8 text-gray-900 tracking-tight" style="font-family: 'Poppins', sans-serif;">
        Available Jobs
    </h1>

    <form method="GET" action="{{ route('jobs.index') }}" class="mb-10">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search jobs..."
            class="w-full p-4 rounded-lg border border-gray-300 text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-3 focus:ring-blue-500 focus:border-blue-500"
            aria-label="Search jobs"
            style="font-family: 'Roboto', sans-serif;"
        >
    </form>

    @if(session('success'))
        <div class="mb-6 p-5 bg-green-100 text-green-900 rounded-lg shadow-sm font-medium" style="font-family: 'Roboto', sans-serif;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-5 bg-red-100 text-red-900 rounded-lg shadow-sm font-medium" style="font-family: 'Roboto', sans-serif;">
            {{ session('error') }}
        </div>
    @endif

    @forelse ($jobs as $job)
        <div class="bg-gray-50 rounded-xl shadow-md p-8 mb-8 hover:shadow-xl transition-shadow duration-300" style="font-family: 'Roboto', sans-serif;">
            <h2 class="text-3xl font-semibold text-gray-900 mb-3 tracking-wide" style="font-family: 'Poppins', sans-serif;">
                {{ $job->title }}
            </h2>
            <p class="text-gray-700 text-lg mb-4 leading-relaxed">
                {{ Str::limit($job->description, 180) }}
            </p>
            <div class="flex flex-wrap items-center text-gray-600 text-sm font-medium space-x-5 mb-5">
                <span>{{ $job->location }}</span>
                <span class="uppercase">{{ $job->type }}</span>
                @if($job->salary)
                    <span class="font-semibold text-gray-800">
                        Salary: ${{ number_format($job->salary) }}
                    </span>
                @endif
            </div>
            <button
                onclick="openModal({{ $job->id }})"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold tracking-wide focus:outline-none focus:ring-4 focus:ring-blue-400"
                aria-label="Apply for {{ $job->title }}"
            >
                Apply
            </button>
        </div>
    @empty
        <p class="text-gray-600 text-xl font-medium">No jobs found.</p>
    @endforelse
</div>

<!-- Modal -->
 @foreach ($jobs as $job)
    <!-- Modal per job -->
    <div
        id="applyModal-{{ $job->id }}"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-6"
        role="dialog"
        aria-modal="true"
        aria-labelledby="applyModalTitle-{{ $job->id }}"
    >
        <div class="bg-white rounded-xl p-6 w-full max-w-lg relative shadow-2xl max-h-[550px] flex flex-col">
            <h2 class="text-3xl font-bold mb-6 text-gray-900" id="applyModalTitle-{{ $job->id }}">
                Apply for {{ $job->title }}
            </h2>

            <form method="POST" action="{{ route('jobs.apply', $job->id) }}" enctype="multipart/form-data" class="space-y-6 overflow-y-auto" style="flex-grow: 1;">
                @csrf
<input type="hidden" name="job_id" value="{{ $job->id }}">
                <div>
                    <label class="block font-semibold text-gray-800 mb-2">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="block font-semibold text-gray-800 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="block font-semibold text-gray-800 mb-2">Cover Letter</label>
                    <textarea name="cover_letter" rows="5" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div>
                    <label class="block font-semibold text-gray-800 mb-2">Upload Resume <span class="text-red-500">*</span></label>
                    <input type="file" name="resume" accept=".pdf,.doc,.docx" required class="w-full" />
                </div>

                <!-- Questions -->
                @if($job->questionGroup && $job->questionGroup->questions->count())
                    <div class="mt-4">
                        <h3 class="font-semibold text-lg mb-2">Additional Questions</h3>
                        @foreach($job->questionGroup->questions as $question)
                            <div class="mb-3">
                             <label class="block text-gray-700 mb-1">{{ $question->question }}</label>

                                <input type="text" name="answers[{{ $question->id }}]" class="w-full border px-3 py-2 rounded" required />
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" onclick="closeModal({{ $job->id }})" class="px-5 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded">Submit</button>
                </div>
            </form>

            <button onclick="closeModal({{ $job->id }})" class="absolute top-3 right-4 text-3xl font-bold text-gray-400 hover:text-gray-600">&times;</button>
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
</script>

@endsection
