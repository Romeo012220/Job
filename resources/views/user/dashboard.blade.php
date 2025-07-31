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

                @php
                    $hasAdminMessage = $application->messages->contains(fn($msg) => $msg->sender_type === 'admin');
                    $displayStatus = $hasAdminMessage ? 'Reviewed' : 'Pending';
                    $badgeColor = $hasAdminMessage ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                    $formattedMessages = $application->messages->map(fn($msg) => [
                        'message' => $msg->message,
                        'sent_at' => $msg->created_at_manila,
                        'sender_type' => $msg->sender_type,
                    ]);
                @endphp

                <p class="text-sm">
                    <strong>Status:</strong> 
                    <span class="inline-block px-2 py-1 rounded-md text-xs font-semibold {{ $badgeColor }}">
                        {{ $displayStatus }}
                    </span>
                </p>

                <p class="text-sm text-gray-500">
                    <strong>Applied On:</strong> {{ $application->created_at->format('F d, Y') }}
                </p>
            </div>

            @if($application->messages->count())
            <div class="relative inline-block">
                <button 
                    class="view-message-btn bg-yellow-100 text-yellow-800 font-medium px-3 py-1 rounded-md text-sm hover:bg-yellow-200 transition"
                    data-id="{{ $application->id }}"
                    data-messages='@json($formattedMessages)'
                >
                    📬 View Message
                </button>

                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full shadow">
                    {{ $application->messages->count() }}
                </span>
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
</div>

<!-- Message Modal -->
<div id="userMessageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative animate-fade-in">
        <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 close-modal text-2xl">&times;</button>
        <h3 class="text-xl font-semibold mb-4 text-blue-700">📩 Admin Message(s)</h3>

        <div id="userMessageContent" class="space-y-3 text-gray-800 text-sm max-h-60 overflow-y-auto border rounded p-2 mb-4 bg-gray-50" style="scroll-behavior: smooth;"></div>

        <form id="messageReplyForm" method="POST" action="{{ route('messages.reply') }}">
            @csrf
            <input type="hidden" name="application_id" id="modalApplicationId">
            <textarea name="message" rows="3" class="w-full border rounded p-2 mb-2" placeholder="Write a reply..." required></textarea>
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                📩 Send Reply
            </button>
        </form>

        
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

        hiddenInput.value = applicationId;
        contentDiv.innerHTML = '';

        messages.forEach(msg => {
            const wrapper = document.createElement('div');
            const isAdmin = msg.sender_type === 'admin';

            wrapper.classList.add(
                'border', 'rounded', 'p-3', 'shadow-sm', 'mb-2',
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

        requestAnimationFrame(() => {
            contentDiv.scrollTop = contentDiv.scrollHeight;
        });

        document.getElementById('userMessageModal').classList.remove('hidden');
    });
});

document.querySelectorAll('.close-modal').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('userMessageModal').classList.add('hidden');
    });
});

const replyForm = document.getElementById('messageReplyForm');

replyForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(replyForm);
    const contentDiv = document.getElementById('userMessageContent');
    const messageText = replyForm.message.value;

    fetch(replyForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Failed to send message.');
        return response.json();
    })
    .then(data => {
        const wrapper = document.createElement('div');
        wrapper.className = 'border rounded p-3 shadow-sm mb-2 bg-gray-100 text-gray-800';

        const label = document.createElement('strong');
        label.textContent = '🙋 You';
        label.className = 'block text-xs mb-1 text-gray-600';

        const message = document.createElement('p');
        message.textContent = messageText;

        const sentAt = document.createElement('p');
        sentAt.className = 'text-xs text-gray-500 mt-1';
        sentAt.textContent = new Date().toLocaleString();

        wrapper.appendChild(label);
        wrapper.appendChild(message);
        wrapper.appendChild(sentAt);
        contentDiv.appendChild(wrapper);

        replyForm.reset();

        requestAnimationFrame(() => {
            contentDiv.scrollTop = contentDiv.scrollHeight;
        });
    })
    .catch(error => {
        alert(error.message);
    });
});
</script>
@endpush
