@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Post a New Job</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-1">Title</label>
                <input type="text" name="title" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-1">Location</label>
                <input type="text" name="location" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-1">Type</label>
                <input type="text" name="type" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label for="question_group_id" class="block font-medium text-gray-700">Attach Question Group (optional)</label>
                <select name="question_group_id" id="question_group_id" class="form-select mt-1 block w-full">
                    <option value="">-- None --</option>
                    @foreach($questionGroups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition duration-200">
                    Post Job
                </button>
            </div>

            @auth
                <div class="text-sm text-gray-600 mt-4">Role: {{ auth()->user()->role }}</div>
            @endauth

        </form>
    </div>
</div>
@endsection
