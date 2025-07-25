@extends('layouts.app')

@section('title', 'Find Jobs')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Available Jobs</h1>

    <form method="GET" action="{{ route('jobs.index') }}" class="mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..." 
               class="w-full p-2 border border-gray-300 rounded">
    </form>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @forelse ($jobs as $job)
        <div class="bg-white p-4 shadow mb-4 rounded">
            <h2 class="text-xl font-semibold">{{ $job->title }}</h2>
            <p class="text-gray-600">{{ $job->description }}</p>
            <p class="text-sm text-gray-500">{{ $job->location }} | {{ $job->type }}</p>
            @if($job->salary)
                <p class="text-sm text-gray-700 font-medium mt-1">Salary: ${{ $job->salary }}</p>
            @endif

            <button onclick="openModal({{ $job->id }})" class="bg-blue-600 text-white px-3 py-1 rounded mt-2">Apply</button>
        </div>
    @empty
        <p>No jobs found.</p>
    @endforelse
</div>

<!-- Modal -->
<div id="applyModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
        <h2 class="text-xl font-bold mb-4">Apply for Job</h2>
        <form id="applyForm" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-3">
                <label for="email" class="block font-medium">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-3">
                <label for="cover_letter" class="block font-medium">Cover Letter</label>
                <textarea name="cover_letter" class="w-full border p-2 rounded" rows="4"></textarea>
            </div>

            <div class="mb-4">
                <label for="resume" class="block font-medium">Upload Resume (PDF, DOC, DOCX)</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full border p-2 rounded" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit Application</button>
            </div>
        </form>

        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 text-xl">&times;</button>
    </div>
</div>

<script>
    function openModal(jobId) {
        const modal = document.getElementById('applyModal');
        const form = document.getElementById('applyForm');
        form.action = `/jobs/apply/${jobId}`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('applyModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.getElementById('applyForm').reset();
    }
</script>
@endsection
