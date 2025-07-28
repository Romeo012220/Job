@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">{{ $group->name }}</h2>

    <ul class="space-y-2">
        @foreach ($group->questions as $question)
            <li class="border-b py-2">{{ $question->question }}</li>
        @endforeach
    </ul>
</div>
@endsection
