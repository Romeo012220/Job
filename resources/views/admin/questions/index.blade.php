@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-8">
    <a href="{{ route('admin.questions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Create New Group</a>

    @foreach ($groups as $group)
        <div class="mt-6 p-4 bg-white shadow rounded">
            <h2 class="text-xl font-bold">{{ $group->name }}</h2>
            <a href="{{ route('admin.questions.show', $group->id) }}" class="text-blue-600">View Questions</a>
            <form action="{{ route('admin.questions.destroy', $group->id) }}" method="POST" class="inline-block ml-4">
                @csrf
                @method('DELETE')
                <button class="text-red-600">Delete Group</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
