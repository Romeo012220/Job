@extends('layouts.app')

@section('title', 'Admin - Job Listings')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">🧑‍💼 Admin Panel – Job Listings</h2>

    @if(session('success'))
        <div id="successAlert" class="bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">Title</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Location</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($jobs as $job)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium">{{ $job->title }}</td>
                    <td class="px-6 py-4 capitalize">{{ str_replace('_', ' ', $job->type) }}</td>
                    <td class="px-6 py-4">{{ $job->category ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $job->location }}</td>
                    <td class="px-6 py-4">
    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
        {{ $job->status === 'open' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
        {{ ucfirst($job->status) }}
    </span>
</td>
                  
                    <td class="px-6 py-4">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-gray-600 hover:text-blue-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-md z-50">
                                <a href="{{ url('admin/jobs/' . $job->id . '/show') }}" class="block px-4 py-2 hover:bg-gray-100 text-blue-600">👁 View</a>

                                @if($job->status === 'open')
                                    <form action="{{ route('admin.jobs.close', $job->id) }}" method="POST" onsubmit="return confirm('Close this job?');">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">🚫 Close</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.jobs.reopen', $job->id) }}" method="POST" onsubmit="return confirm('Reopen this job?');">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-green-600">✅ Reopen</button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Delete this job?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-700">🗑 Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center px-6 py-8 text-gray-500">No jobs posted yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $jobs->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
@endpush
