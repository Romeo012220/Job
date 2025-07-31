@extends('layouts.app')

@section('title', 'Job Applications')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 bg-white rounded-xl shadow-md">
    <h1 class="text-4xl font-bold mb-8 text-gray-800">📋 Job Applications</h1>

    @if($applications->count())
        <div class="overflow-x-auto rounded-lg border">
            <table class="min-w-full table-auto text-sm text-left">
                <thead class="bg-gray-100 border-b text-gray-700">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Job</th>
                        <th class="px-4 py-3">Cover Letter</th>
                        <th class="px-4 py-3">Applied At</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $application->name }}</td>
                            <td class="px-4 py-3">{{ $application->email }}</td>
                            <td class="px-4 py-3">{{ $application->job->title ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ Str::limit($application->cover_letter, 60) }}</td>
                            <td class="px-4 py-3">{{ $application->created_at->timezone('Asia/Manila')->format('Y-m-d h:i A') }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.applications.show', $application->id) }}"
                                   class="inline-block px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                   View
                                </a>
                                <button 
                                    data-id="{{ $application->id }}" 
                                    data-name="{{ $application->name }}" 
                                    data-email="{{ $application->email }}"
                                    class="open-message-modal inline-block px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                    Message
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @else
        <div class="text-gray-600 text-lg font-medium">No applications found.</div>
    @endif
</div>
@endsection
<!-- Message Modal -->
<div id="messageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl flex flex-col h-[85vh]">
        <!-- Header -->
        <div class="px-6 py-4 border-b flex justify-between items-center bg-blue-50 rounded-t-xl">
            <h2 class="text-xl font-bold text-blue-700">💬 Messages</h2>
            <button class="close-modal text-gray-600 hover:text-red-600 text-2xl font-bold">&times;</button>
        </div>

        <!-- Chat History -->
        <div id="chatHistory" class="flex-1 overflow-y-auto px-4 py-4 space-y-4 bg-gray-100">
            <div id="messageList" class="space-y-3"></div>
        </div>

        <!-- Send Message -->
        <form id="messageForm" method="POST" action="{{ route('admin.applications.sendMessage') }}" class="border-t bg-white px-6 py-4 rounded-b-xl">
            @csrf
            <input type="hidden" name="application_id" id="application_id">
            <textarea name="message" class="w-full border-gray-300 rounded-lg p-3 resize-none focus:ring-2 focus:ring-blue-300" rows="3" placeholder="Type your message..." required></textarea>
            <div class="flex justify-end mt-3 space-x-2">
                <button type="button" class="close-modal px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700">Send</button>
            </div>
        </form>
    </div>
</div>


@push('scripts')
<script>
    const modal = document.getElementById('messageModal');
    const form = document.getElementById('messageForm');
    const idInput = document.getElementById('application_id');
    const messageList = document.getElementById('messageList');
    const chatHistory = document.getElementById('chatHistory');

    document.querySelectorAll('.open-message-modal').forEach(button => {
     button.addEventListener('click', () => {
    const appId = button.dataset.id;
    const applicantName = button.dataset.name; // Get name
    idInput.value = appId;
    messageList.innerHTML = '';
    modal.classList.remove('hidden');


            fetch(`/admin/applications/${appId}/messages`)
                .then(res => res.json())
                .then(messages => {
                    messages.forEach(msg => {
                        const wrapper = document.createElement('div');
                        wrapper.className = `flex ${msg.sender_type === 'admin' ? 'justify-end' : 'justify-start'}`;

                        const bubble = document.createElement('div');
                        bubble.className = `p-3 max-w-xs rounded-lg shadow text-sm whitespace-pre-wrap ${
                            msg.sender_type === 'admin' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900'
                        }`;
                      bubble.innerHTML = `
    <div class="font-semibold text-xs mb-1 ${msg.sender_type === 'admin' ? 'text-yellow-200' : 'text-gray-500'}">
        ${msg.sender_type === 'admin' ? 'Admin' : 'Applicant'}
    </div>
    <div>${msg.message}</div>
    <div class="text-[10px] opacity-70 mt-1">${new Date(msg.created_at).toLocaleString()}</div>
`;


                        wrapper.appendChild(bubble);
                        messageList.appendChild(wrapper);
                    });

                    chatHistory.scrollTop = chatHistory.scrollHeight;
                });
        });
    });

    // Close modal
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            modal.classList.add('hidden');
            form.reset();
            messageList.innerHTML = '';
        });
    });






    form.addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Message send failed');
        }
        return response.json(); // If your controller returns JSON
    })
    .then(data => {
        // Add message to chat window
        const wrapper = document.createElement('div');
        wrapper.className = 'flex justify-end';

        const bubble = document.createElement('div');
        bubble.className = 'p-3 max-w-xs rounded-lg shadow text-sm whitespace-pre-wrap bg-blue-500 text-white';
        bubble.innerHTML = `
            <div class="font-semibold text-xs mb-1 text-yellow-200">Admin</div>
            <div>${form.message.value}</div>
            <div class="text-[10px] opacity-70 mt-1">${new Date().toLocaleString()}</div>
        `;

        wrapper.appendChild(bubble);
        messageList.appendChild(wrapper);

        chatHistory.scrollTop = chatHistory.scrollHeight;
        form.reset(); // Clear the form
    })
    .catch(error => {
        alert(error.message);
    });
});

</script>
@endpush
