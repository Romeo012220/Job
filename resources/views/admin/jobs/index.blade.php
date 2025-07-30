@extends('layouts.app')

@section('title', 'Admin - Job Listings')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Admin - All Job Posts</h2>

 @if(session('success'))
    <div id="successAlert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
        {{ session('success') }}
    </div>
@endif


    <table class="min-w-full bg-white shadow border">

    <thead>
    <tr class="bg-gray-100 text-left">
        <th class="py-2 px-4 border-b">Title</th>
        <th class="py-2 px-4 border-b">Type</th>
        <th class="py-2 px-4 border-b">Category</th> <!-- Added -->
        <th class="py-2 px-4 border-b">Location</th>
        <th class="py-2 px-4 border-b">Salary</th>
        <th class="py-2 px-4 border-b">Actions</th>
    </tr>
</thead>
<tbody>
    @forelse($jobs as $job)
        <tr>
            <td class="py-2 px-4 border-b">{{ $job->title }}</td>
           <td class="py-2 px-4 border-b">
    {{ ucwords(str_replace('_', ' ', $job->type)) }}
</td>
            <td class="py-2 px-4 border-b">{{ $job->category ?? 'N/A' }}</td> <!-- Added -->
            <td class="py-2 px-4 border-b">{{ $job->location }}</td>
            <td class="py-2 px-4 border-b">₱{{ number_format($job->salary, 2) }}</td>
            <td class="py-2 px-4 border-b flex space-x-2">
          <a href="{{ url('admin/jobs/' . $job->id . '/show') }}" class="text-blue-600 hover:underline">View</a>




                @if($job->status === 'open')
                    <form action="{{ route('admin.jobs.close', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to close this job?');">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Close</button>
                    </form>
                @else
                    <span class="text-gray-500 italic">Closed</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="py-4 px-4 text-center text-gray-500">No jobs posted yet.</td>
        </tr>
    @endforelse
</tbody>

    </table>

    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</div>
@endsection



@push('scripts')
<script>
    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000); // Disappear after 3 seconds
</script>
@endpush
