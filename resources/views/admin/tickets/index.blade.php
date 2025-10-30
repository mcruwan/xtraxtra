<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Support Tickets Management') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Manage and respond to support tickets from universities.</p>
            </div>
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
                    <span class="sr-only">Success</span>
                    <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Status Tabs -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden mb-6">
                <div class="border-b border-gray-200">
                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 overflow-x-auto">
                        <li class="me-2">
                            <a href="{{ route('admin.tickets.index') }}" 
                               class="inline-block p-4 {{ !request('status') ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}">
                                All
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ !request('status') ? 'text-blue-800 bg-blue-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['all'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" 
                               class="inline-block p-4 {{ request('status') === 'open' ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}">
                                Open
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'open' ? 'text-blue-800 bg-blue-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['open'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.tickets.index', ['status' => 'in_progress']) }}" 
                               class="inline-block p-4 {{ request('status') === 'in_progress' ? 'text-yellow-600 border-b-2 border-yellow-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}">
                                In Progress
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'in_progress' ? 'text-yellow-800 bg-yellow-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['in_progress'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.tickets.index', ['status' => 'resolved']) }}" 
                               class="inline-block p-4 {{ request('status') === 'resolved' ? 'text-green-600 border-b-2 border-green-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}">
                                Resolved
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'resolved' ? 'text-green-800 bg-green-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['resolved'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" 
                               class="inline-block p-4 {{ request('status') === 'closed' ? 'text-gray-600 border-b-2 border-gray-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}">
                                Closed
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'closed' ? 'text-gray-800 bg-gray-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['closed'] }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Filters -->
                <div class="px-4 py-3 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.tickets.index') }}" class="flex flex-wrap items-end gap-3">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        
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

                        <div class="flex-shrink-0 min-w-[160px]">
                            <label for="university_id" class="block text-xs font-medium text-gray-600 mb-1">University</label>
                            <select name="university_id" id="university_id" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                                <option value="" class="text-gray-900">All Universities</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}" {{ request('university_id') == $university->id ? 'selected' : '' }} class="text-gray-900">
                                        {{ $university->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-shrink-0 min-w-[140px]">
                            <label for="assigned_to" class="block text-xs font-medium text-gray-600 mb-1">Assigned To</label>
                            <select name="assigned_to" id="assigned_to" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                                <option value="" class="text-gray-900">All Admins</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ request('assigned_to') == $admin->id ? 'selected' : '' }} class="text-gray-900">
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-shrink-0 flex-1 min-w-[200px]">
                            <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Search</label>
                            <div class="flex gap-2">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search tickets..." class="flex-1 px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <button type="submit" class="px-3 py-1.5 text-sm bg-blue-700 text-white rounded-md hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 whitespace-nowrap">
                                    Apply
                                </button>
                                <a href="{{ route('admin.tickets.index') }}" class="px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:ring-2 focus:ring-gray-300 whitespace-nowrap flex items-center" title="Reset filters">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tickets Table -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                @if($tickets->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Ticket</th>
                                    <th scope="col" class="px-6 py-3">University</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Priority</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Assigned To</th>
                                    <th scope="col" class="px-6 py-3">Replies</th>
                                    <th scope="col" class="px-6 py-3">Last Reply</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">
                                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="hover:text-blue-600 hover:underline">
                                                    #{{ $ticket->id }} - {{ Str::limit($ticket->subject, 40) }}
                                                </a>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                by {{ $ticket->creator->name }} • {{ $ticket->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $ticket->university->name }}
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
                                        <td class="px-6 py-4 text-xs text-gray-600">
                                            {{ $ticket->assignedAdmin ? $ticket->assignedAdmin->name : 'Unassigned' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $ticket->messages->count() }}
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500">
                                            {{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : 'No replies' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-900 font-medium">
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
                        <p class="mt-1 text-sm text-gray-500">No tickets match your current filters.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>

