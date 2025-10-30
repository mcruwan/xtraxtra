<x-university-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ $ticket->subject }}</h1>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($ticket->status == 'open') bg-blue-100 text-blue-800
                                @elseif($ticket->status == 'in_progress') bg-yellow-100 text-yellow-800
                                @elseif($ticket->status == 'resolved') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($ticket->priority == 'high') bg-red-100 text-red-800
                                @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($ticket->priority) }} Priority
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">
                            Ticket #{{ $ticket->id }} • {{ $ticket->category_label }} • Created {{ $ticket->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($ticket->isOpen())
                            <form method="POST" action="{{ route('university.tickets.close', $ticket) }}" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure you want to close this ticket?')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Close Ticket
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('university.tickets.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Tickets
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div id="success-alert" class="flex p-4 mb-6 text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-green-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Ticket Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Original Request</h3>
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $ticket->creator->name }}
                        <span class="text-gray-400">•</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $ticket->created_at->format('M d, Y \a\t h:i A') }}
                    </div>
                </div>
                <div class="prose max-w-none text-gray-700">
                    {{ $ticket->description }}
                </div>
                
                @if($ticket->hasImage())
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Screenshot</h4>
                        <div class="max-w-md">
                            <img src="{{ $ticket->image_url }}" alt="Ticket screenshot" class="rounded-lg shadow-sm border border-gray-200 cursor-pointer" onclick="openImageModal('{{ $ticket->image_url }}')">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Conversation -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Conversation ({{ $ticket->messages->count() }} {{ $ticket->messages->count() == 1 ? 'reply' : 'replies' }})
                </h3>
                
                @if($ticket->messages->count() > 0)
                    <div class="space-y-4">
                        @foreach($ticket->messages as $message)
                            <div class="flex gap-4 {{ $message->user->isAdmin() || $message->user->isSuperAdmin() ? 'bg-blue-50 -mx-6 -my-2 px-6 py-4' : '' }}">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full {{ $message->user->isAdmin() || $message->user->isSuperAdmin() ? 'bg-blue-600' : 'bg-gray-400' }} flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-gray-900">{{ $message->user->name }}</span>
                                        @if($message->user->isAdmin() || $message->user->isSuperAdmin())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                Support Team
                                            </span>
                                        @endif
                                        <span class="text-xs text-gray-500">
                                            {{ $message->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p>No replies yet. Our team will respond soon.</p>
                    </div>
                @endif
            </div>

            <!-- Reply Form -->
            @if($ticket->isOpen())
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Add a Reply</h3>
                    <form method="POST" action="{{ route('university.tickets.reply', $ticket) }}">
                        @csrf
                        <div class="mb-4">
                            <textarea name="message" 
                                      id="message" 
                                      rows="5"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror"
                                      placeholder="Type your reply here..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end gap-3">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">This ticket is {{ $ticket->status }}</h3>
                    <p class="text-sm text-gray-600">You cannot add replies to a {{ $ticket->status }} ticket.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Screenshot</h3>
                    <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="text-center">
                    <img id="modalImage" src="" alt="Screenshot" class="max-w-full h-auto rounded-lg">
                </div>
            </div>
        </div>
    </div>

    <script>
        function openImageModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
</x-university-layout>

