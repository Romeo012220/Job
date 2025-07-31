@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')


<div class="max-w-5xl mx-auto mt-10 px-4">
    <h1 class="text-4xl font-bold text-blue-700 mb-8">📌 My Job Applications</h1>

    @forelse($applications as $application)
    <div class="mb-6 bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-lg transition">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-1">
                    {{ strtoupper($application->job->title) }}
                </h2>
                <p class="text-gray-600"><strong>Status:</strong> {{ ucfirst($application->status) }}</p>
                <p class="text-sm text-gray-500">
                    <strong>Applied On:</strong> {{ $application->created_at->format('F d, Y') }}
                </p>
            </div>

            @if($application->messages->count())
          
          <div class="relative inline-block">
    <button 
        class="view-message-btn bg-yellow-100 text-yellow-800 font-medium px-3 py-1 rounded-md text-sm hover:bg-yellow-200 transition"
        data-id="{{ $application->id }}" 
        

  @php
$formattedMessages = $application->messages->map(function($msg) {
    return [
        'message' => $msg->message,
        'sent_at' => $msg->created_at_manila,
        'sender_type' => $msg->sender_type
    ];
});
@endphp


<button 
    class="view-message-btn bg-yellow-100 text-yellow-800 font-medium px-3 py-1 rounded-md text-sm hover:bg-yellow-200 transition"
    data-id="{{ $application->id }}"
    data-messages='@json($formattedMessages)'
>
    📬 View Message
</button>


    @if($application->messages->count())
    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full shadow">
        {{ $application->messages->count() }}
    </span>
    @endif
</div>

            @endif
        </div>

        <div class="mt-4 text-right">
            <a href="{{ route('applications.show', $application->id) }}"
               class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                📄 View Application
            </a>
        </div>
    </div>
    @empty
        <div class="bg-white p-6 rounded-xl shadow text-center text-gray-600">
            You haven't applied to any jobs yet.
        </div>
    @endforelse
<!-- Message Modal -->
<div id="userMessageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative animate-fade-in">
        <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 close-modal text-2xl">&times;</button>
        <h3 class="text-xl font-semibold mb-4 text-blue-700">📩 Admin Message(s)</h3>

        <div id="userMessageContent" class="space-y-3 text-gray-800 text-sm max-h-60 overflow-y-auto border rounded p-2 mb-4 bg-gray-50"></div>

        <!-- Reply form -->
        <form id="messageReplyForm" method="POST" action="{{ route('messages.reply') }}">
            @csrf
            <input type="hidden" name="application_id" id="modalApplicationId">
            <textarea name="message" rows="3" class="w-full border rounded p-2 mb-2" placeholder="Write a reply..." required></textarea>
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                📩 Send Reply
            </button>
        </form>

        <div class="mt-4 text-right">
            <button class="close-modal bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 text-sm">Close</button>
        </div>
    </div>
</div>


@endsection
@push('scripts')
<script>
    document.querySelectorAll('.view-message-btn').forEach(button => {
    button.addEventListener('click', () => {
        const messages = JSON.parse(button.getAttribute('data-messages'));
        const applicationId = button.getAttribute('data-id');
        const contentDiv = document.getElementById('userMessageContent');
        const hiddenInput = document.getElementById('modalApplicationId');

        hiddenInput.value = applicationId; // 👈 set application_id
        contentDiv.innerHTML = '';

        if (messages.length > 0) {
      messages.forEach(msg => {
    const wrapper = document.createElement('div');
    const isAdmin = msg.sender_type === 'admin';

    wrapper.classList.add(
        'border',
        'rounded',
        'p-3',
        'shadow-sm',
        'mb-2',
        isAdmin ? 'bg-blue-100' : 'bg-gray-100',
        isAdmin ? 'text-blue-900' : 'text-gray-800'
    );

    const label = document.createElement('strong');
    label.textContent = isAdmin ? '👤 Admin' : '🙋 You';
    label.classList.add('block', 'text-xs', 'mb-1', isAdmin ? 'text-blue-600' : 'text-gray-600');

    const messageText = document.createElement('p');
    messageText.textContent = msg.message;

    const sentAt = document.createElement('p');
    sentAt.textContent = msg.sent_at;
    sentAt.classList.add('text-xs', 'text-gray-500', 'mt-1');

    wrapper.appendChild(label);
    wrapper.appendChild(messageText);
    wrapper.appendChild(sentAt);
    contentDiv.appendChild(wrapper);
});


        }

        document.getElementById('userMessageModal').classList.remove('hidden');
    });
});


    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('userMessageModal').classList.add('hidden');
        });
    });
</script>
@endpush
