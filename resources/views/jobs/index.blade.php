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
<div
    id="applyModal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-6"
    role="dialog"
    aria-modal="true"
    aria-labelledby="applyModalTitle"
>
    <div
        class="bg-white rounded-xl p-6 w-full max-w-lg relative shadow-2xl max-h-[550px] flex flex-col"
        style="font-family: 'Roboto', sans-serif;"
    >
        <h2
            id="applyModalTitle"
            class="text-3xl font-bold mb-6 text-gray-900"
            style="font-family: 'Poppins', sans-serif;"
        >
            Apply for Job
        </h2>

        <form
            id="applyForm"
            method="POST"
            action=""
            enctype="multipart/form-data"
            class="space-y-6 overflow-y-auto"
            style="flex-grow: 1;"
        >
            @csrf
            <div>
                <label for="name" class="block text-gray-800 font-semibold mb-2 text-lg">Name <span class="text-red-500">*</span></label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-lg focus:outline-none focus:ring-3 focus:ring-blue-500"
                    required
                    autocomplete="name"
                >
            </div>

            <div>
                <label for="email" class="block text-gray-800 font-semibold mb-2 text-lg">Email <span class="text-red-500">*</span></label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-lg focus:outline-none focus:ring-3 focus:ring-blue-500"
                    required
                    autocomplete="email"
                >
            </div>

            <div>
                <label for="cover_letter" class="block text-gray-800 font-semibold mb-2 text-lg">Cover Letter</label>
                <textarea
                    id="cover_letter"
                    name="cover_letter"
                    rows="6"
                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-lg focus:outline-none focus:ring-3 focus:ring-blue-500 resize-none"
                    placeholder="Write your cover letter here..."
                ></textarea>
            </div>

            <div>
                <label for="resume" class="block text-gray-800 font-semibold mb-2 text-lg">
                    Upload Resume (PDF, DOC, DOCX) <span class="text-red-500">*</span>
                </label>
                <input
                    id="resume"
                    type="file"
                    name="resume"
                    accept=".pdf,.doc,.docx"
                    class="w-full"
                    required
                >
            </div>

            <div class="flex justify-end space-x-5 mt-4">
                <button
                    type="button"
                    onclick="closeModal()"
                    class="px-8 py-3 rounded-lg bg-gray-300 text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-3 focus:ring-gray-500"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-8 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-3 focus:ring-blue-500 font-semibold tracking-wide"
                >
                    Submit Application
                </button>
            </div>
        </form>

        <button
            onclick="closeModal()"
            class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 text-4xl font-bold"
            aria-label="Close modal"
        >
            &times;
        </button>
    </div>
</div>


<script>
    function openModal(jobId) {
        const modal = document.getElementById('applyModal');
        const form = document.getElementById('applyForm');
        form.action = `/jobs/${jobId}/apply`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('applyModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.getElementById('applyForm').reset();
        document.body.style.overflow = '';
    }
</script>
@endsection
