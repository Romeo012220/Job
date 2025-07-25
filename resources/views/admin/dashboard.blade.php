@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
    <p>Welcome, Admin!</p>
    <a href="{{ route('admin.jobs.create') }}">Post a New Job</a>

</div>
@endsection
