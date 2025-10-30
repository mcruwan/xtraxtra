<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Ticket #{{ $ticket->id }}: {{ $ticket->subject }}
                    </h2>
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
                    {{ $ticket->university->name }} • {{ $ticket->category_label }} • Created {{ $ticket->created_at->diffForHumans() }}
                </p>
            </div>
            <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Tickets
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-lg bg-green-50" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Original Request -->
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Original Request</h3>
                            <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $ticket->creator->name }} ({{ $ticket->creator->email }})
                                <span class="text-gray-400">•</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $ticket->created_at->format('M d, Y \a\t h:i A') }}
                            </div>
                        </div>
                        <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">{{ $ticket->description }}</div>
                        
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
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Conversation ({{ $ticket->messages->where('is_internal_note', false)->count() }} {{ $ticket->messages->where('is_internal_note', false)->count() == 1 ? 'reply' : 'replies' }})
                        </h3>
                        
                        @if($ticket->messages->count() > 0)
                            <div class="space-y-4">
                                @foreach($ticket->messages as $message)
                                    <div class="flex gap-4 {{ $message->isFromAdmin() ? 'bg-blue-50 -mx-6 px-6 py-4' : ($message->is_internal_note ? 'bg-yellow-50 -mx-6 px-6 py-4 border-l-4 border-yellow-500' : 'py-2') }}">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full {{ $message->isFromAdmin() ? 'bg-blue-600' : 'bg-gray-400' }} flex items-center justify-center text-white font-semibold">
                                                {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-semibold text-gray-900">{{ $message->user->name }}</span>
                                                @if($message->isFromAdmin())
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                        Support Team
                                                    </span>
                                                @endif
                                                @if($message->is_internal_note)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Internal Note (Not visible to university)
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
                                <p>No replies yet. Be the first to respond!</p>
                            </div>
                        @endif
                    </div>

                    <!-- Reply Forms -->
                    @if($ticket->status != 'closed')
                        <!-- Public Reply Form -->
                        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Send Reply to University</h3>
                            <form method="POST" action="{{ route('admin.tickets.reply', $ticket) }}">
                                @csrf
                                <input type="hidden" name="is_internal_note" value="0">
                                <div class="mb-4">
                                    <textarea name="message" 
                                              id="public_message" 
                                              rows="5"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror"
                                              placeholder="Type your reply here... This will be visible to the university."
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Send Reply
                                </button>
                            </form>
                        </div>

                        <!-- Internal Note Form -->
                        <div class="bg-yellow-50 rounded-lg border-2 border-yellow-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Add Internal Note
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">Internal notes are only visible to admins, not to the university.</p>
                            <form method="POST" action="{{ route('admin.tickets.reply', $ticket) }}">
                                @csrf
                                <input type="hidden" name="is_internal_note" value="1">
                                <div class="mb-4">
                                    <textarea name="message" 
                                              id="internal_message" 
                                              rows="3"
                                              class="w-full px-4 py-3 border border-yellow-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                              placeholder="Add internal notes for team members..."
                                              required></textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-yellow-900 bg-yellow-200 rounded-lg hover:bg-yellow-300 focus:ring-4 focus:ring-yellow-400">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Add Internal Note
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Ticket Management -->
                <div class="space-y-6">
                    <!-- Status Management -->
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ticket Status</h3>
                        <form method="POST" action="{{ route('admin.tickets.update-status', $ticket) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }} class="text-gray-900">Open</option>
                                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }} class="text-gray-900">In Progress</option>
                                <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }} class="text-gray-900">Resolved</option>
                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }} class="text-gray-900">Closed</option>
                            </select>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Priority Management -->
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Priority</h3>
                        <form method="POST" action="{{ route('admin.tickets.update-priority', $ticket) }}">
                            @csrf
                            @method('PATCH')
                            <select name="priority" class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                                <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }} class="text-gray-900">Low</option>
                                <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }} class="text-gray-900">Medium</option>
                                <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }} class="text-gray-900">High</option>
                            </select>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                                Update Priority
                            </button>
                        </form>
                    </div>

                    <!-- Assignment -->
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Assign To</h3>
                        <form method="POST" action="{{ route('admin.tickets.assign', $ticket) }}">
                            @csrf
                            @method('PATCH')
                            <select name="assigned_to" class="w-full px-3 py-2 mb-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                                <option value="" class="text-gray-900">Unassigned</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }} class="text-gray-900">
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                                Update Assignment
                            </button>
                        </form>
                    </div>

                    <!-- Ticket Info -->
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ticket Information</h3>
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="font-medium text-gray-700">Created</dt>
                                <dd class="text-gray-600">{{ $ticket->created_at->format('M d, Y \a\t h:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-700">Last Reply</dt>
                                <dd class="text-gray-600">{{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : 'No replies yet' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-700">Created By</dt>
                                <dd class="text-gray-600">{{ $ticket->creator->name }}</dd>
                                <dd class="text-xs text-gray-500">{{ $ticket->creator->email }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-700">University</dt>
                                <dd class="text-gray-600">{{ $ticket->university->name }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-700">Total Replies</dt>
                                <dd class="text-gray-600">{{ $ticket->messages->count() }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
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
</x-admin-layout>

