<x-university-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Support Tickets</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Communicate with our team about news articles, bugs, or any other issues
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('university.tickets.create') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create New Ticket
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

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2 mb-8">
                <!-- Total Card -->
                <div class="p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Total</p>
                            <p class="text-lg font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0 mt-0.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Open Card -->
                <a href="{{ route('university.tickets.index', ['status' => 'open']) }}" class="p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Open</p>
                            <p class="text-lg font-bold text-gray-900">{{ $stats['open'] }}</p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-blue-400 flex-shrink-0 mt-0.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- In Progress Card -->
                <a href="{{ route('university.tickets.index', ['status' => 'in_progress']) }}" class="p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">In Progress</p>
                            <p class="text-lg font-bold text-gray-900">{{ $stats['in_progress'] }}</p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-yellow-400 flex-shrink-0 mt-0.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Resolved Card -->
                <a href="{{ route('university.tickets.index', ['status' => 'resolved']) }}" class="p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Resolved</p>
                            <p class="text-lg font-bold text-gray-900">{{ $stats['resolved'] }}</p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-green-400 flex-shrink-0 mt-0.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Closed Card -->
                <a href="{{ route('university.tickets.index', ['status' => 'closed']) }}" class="p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Closed</p>
                            <p class="text-lg font-bold text-gray-900">{{ $stats['closed'] }}</p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0 mt-0.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3 mb-6">
                <form method="GET" action="{{ route('university.tickets.index') }}" class="flex flex-wrap items-end gap-3">
                    <div class="flex-shrink-0 min-w-[120px]">
                        <label for="status" class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="status" id="status" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                            <option value="" class="text-gray-900">All</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }} class="text-gray-900">Open</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }} class="text-gray-900">In Progress</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }} class="text-gray-900">Resolved</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }} class="text-gray-900">Closed</option>
                        </select>
                    </div>

                    <div class="flex-shrink-0 min-w-[120px]">
                        <label for="priority" class="block text-xs font-medium text-gray-600 mb-1">Priority</label>
                        <select name="priority" id="priority" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                            <option value="" class="text-gray-900">All</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }} class="text-gray-900">Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }} class="text-gray-900">Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }} class="text-gray-900">High</option>
                        </select>
                    </div>

                    <div class="flex-shrink-0 min-w-[140px]">
                        <label for="category" class="block text-xs font-medium text-gray-600 mb-1">Category</label>
                        <select name="category" id="category" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                            <option value="" class="text-gray-900">All</option>
                            <option value="news_article" {{ request('category') == 'news_article' ? 'selected' : '' }} class="text-gray-900">News Article</option>
                            <option value="bug_report" {{ request('category') == 'bug_report' ? 'selected' : '' }} class="text-gray-900">Bug Report</option>
                            <option value="feature_request" {{ request('category') == 'feature_request' ? 'selected' : '' }} class="text-gray-900">Feature Request</option>
                            <option value="general" {{ request('category') == 'general' ? 'selected' : '' }} class="text-gray-900">General</option>
                            <option value="other" {{ request('category') == 'other' ? 'selected' : '' }} class="text-gray-900">Other</option>
                        </select>
                    </div>

                    <div class="flex-shrink-0 flex-1 min-w-[200px]">
                        <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Search</label>
                        <div class="flex gap-2">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search tickets..." class="flex-1 px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="px-3 py-1.5 text-sm bg-blue-700 text-white rounded-md hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 whitespace-nowrap">
                                Apply
                            </button>
                            <a href="{{ route('university.tickets.index') }}" class="px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:ring-2 focus:ring-gray-300 whitespace-nowrap flex items-center" title="Reset filters">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tickets List -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                @if($tickets->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Subject</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Priority</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Replies</th>
                                    <th scope="col" class="px-6 py-3">Last Reply</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('university.tickets.show', $ticket) }}" class="hover:text-blue-600 hover:underline">
                                                    {{ $ticket->subject }}
                                                </a>
                                                @if($ticket->has_unread_reply)
                                                    <span class="inline-flex items-center justify-center w-2 h-2 bg-red-500 rounded-full" title="New reply from support team"></span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs px-2 py-1 bg-gray-100 text-gray-800 rounded">
                                                {{ $ticket->category_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($ticket->priority == 'high') bg-red-100 text-red-800
                                                @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($ticket->status == 'open') bg-blue-100 text-blue-800
                                                @elseif($ticket->status == 'in_progress') bg-yellow-100 text-yellow-800
                                                @elseif($ticket->status == 'resolved') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $ticket->messages->count() }}
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500">
                                            {{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('university.tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $tickets->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No tickets found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new support ticket.</p>
                        <div class="mt-6">
                            <a href="{{ route('university.tickets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create New Ticket
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-university-layout>

