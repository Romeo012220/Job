@extends('layouts.app')

@section('title', 'Job Details')

@section('content')

@if (session('success'))
    <div id="successAlert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 max-w-3xl mx-auto text-center font-sans text-base">
        {{ session('success') }}
    </div>
@endif

<div class="min-h-screen bg-gray-50 py-10 px-4 font-sans">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-10 space-y-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <h2 class="text-3xl font-extrabold text-gray-800 uppercase tracking-wide">
                {{ strtoupper($job->title) }}
            </h2>
            <a href="{{ route('admin.jobs.edit', $job->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transition">
                ✏️ Edit Job
            </a>
        </div>

        {{-- Job Summary --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 text-[15px] leading-relaxed">
            <div>
                <p class="text-gray-500 text-sm uppercase font-medium mb-1">Job Type (Legacy)</p>
                <p class="text-lg font-semibold text-gray-800 uppercase">{{ $job->type }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm uppercase font-medium mb-1">Job Type</p>
                <p class="text-lg font-semibold text-gray-800 uppercase">{{ $job->job_type ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm uppercase font-medium mb-1">Location</p>
                <p class="text-lg font-semibold text-gray-800 uppercase">{{ $job->location }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm uppercase font-medium mb-1">Salary</p>
                <p class="text-lg font-semibold text-gray-800 uppercase">₱{{ number_format($job->salary, 2) }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm uppercase font-medium mb-1">Education</p>
                <p class="text-lg font-semibold text-gray-800 uppercase">{{ $job->education ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Description --}}
        <div>
            <h3 class="text-xl font-bold text-gray-700 mb-3 uppercase tracking-wide">Job Description</h3>
            <div class="prose max-w-none text-gray-700 text-base leading-relaxed">
                {!! nl2br(e($job->description)) !!}
            </div>
        </div>

        {{-- Qualifications --}}
        <div>
            <h3 class="text-xl font-bold text-gray-700 mb-3 uppercase tracking-wide">Qualifications</h3>
            <div class="prose max-w-none text-gray-700 text-base leading-relaxed uppercase">
                {!! nl2br(e($job->qualifications)) !!}
            </div>
        </div>

        {{-- Back Button --}}
        <div>
            <a href="{{ route('admin.jobs.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition uppercase tracking-wide">
                ← Back to Job Listings
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('successAlert');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        }
    });
</script>
@endpush

@endsection
