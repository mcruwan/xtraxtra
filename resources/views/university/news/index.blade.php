<x-university-layout>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header - Flowbite -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">News Submissions</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Manage your university's news submissions and articles
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('university.news.create') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create New Submission
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages - Flowbite Alerts -->
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

            @if(session('error'))
                <div id="error-alert" class="flex p-4 mb-6 text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-red-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Statistics Cards - Flowbite Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-8">
                <!-- Total Card -->
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Total</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Drafts Card -->
                <a href="{{ route('university.news.index', ['status' => 'draft']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Drafts</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['drafts'] }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Pending Card -->
                <a href="{{ route('university.news.index', ['status' => 'pending']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Pending</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Approved Card -->
                <a href="{{ route('university.news.index', ['status' => 'approved']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Approved</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['approved'] }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Published Card -->
                <a href="{{ route('university.news.index', ['status' => 'published']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Published</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['published'] }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Rejected Card -->
                <a href="{{ route('university.news.index', ['status' => 'rejected']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Rejected</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Search and Filters - Flowbite Form -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input with Button -->
                    <div class="md:col-span-2">
                        <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search</label>
                        <form method="GET" action="{{ route('university.news.index') }}" class="flex gap-2">
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            @if(request('sort_by'))
                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                            @endif
                            @if(request('sort_direction'))
                                <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                            @endif
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search by title or excerpt..."
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                            </div>
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 whitespace-nowrap">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                </svg>
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Filter by Status</label>
                        <form method="GET" action="{{ route('university.news.index') }}" id="status-form">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('sort_by'))
                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                            @endif
                            @if(request('sort_direction'))
                                <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                            @endif
                            <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onchange="document.getElementById('status-form').submit();">
                                <option value="">All Submissions</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Drafts</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Clear Filters Button -->
                @if(request('status') || request('search'))
                    <div class="flex items-center mt-4">
                        <a href="{{ route('university.news.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>

            <!-- News Submissions List - Flowbite Table -->
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                @if($newsSubmissions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    @php
                                        $currentSort = request('sort_by', 'created_at');
                                        $currentDirection = request('sort_direction', 'desc');
                                        
                                        function getSortUrl($column, $currentSort, $currentDirection) {
                                            $params = request()->except(['sort_by', 'sort_direction']);
                                            if ($currentSort === $column) {
                                                $params['sort_by'] = $column;
                                                $params['sort_direction'] = $currentDirection === 'asc' ? 'desc' : 'asc';
                                            } else {
                                                $params['sort_by'] = $column;
                                                $params['sort_direction'] = 'asc';
                                            }
                                            return route('university.news.index', $params);
                                        }
                                    @endphp
                                    
                                    <th scope="col" class="px-6 py-3">
                                        <a href="{{ getSortUrl('id', $currentSort, $currentDirection) }}" class="flex items-center gap-1.5 cursor-pointer hover:text-gray-900 group transition-colors">
                                            <span>Post ID</span>
                                            <div class="flex flex-col -space-y-0.5">
                                                <svg class="w-2.5 h-2.5 {{ $currentSort === 'id' && $currentDirection === 'asc' ? 'text-blue-600' : ($currentSort === 'id' ? 'text-gray-400' : 'text-gray-300 group-hover:text-gray-400') }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                                <svg class="w-2.5 h-2.5 {{ $currentSort === 'id' && $currentDirection === 'desc' ? 'text-blue-600' : ($currentSort === 'id' ? 'text-gray-400' : 'text-gray-300 group-hover:text-gray-400') }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="{{ getSortUrl('title', $currentSort, $currentDirection) }}" class="flex items-center gap-1.5 cursor-pointer hover:text-gray-900 group transition-colors">
                                            <span>Title</span>
                                            <div class="flex flex-col -space-y-0.5">
                                                <svg class="w-2.5 h-2.5 {{ $currentSort === 'title' && $currentDirection === 'asc' ? 'text-blue-600' : ($currentSort === 'title' ? 'text-gray-400' : 'text-gray-300 group-hover:text-gray-400') }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                                <svg class="w-2.5 h-2.5 {{ $currentSort === 'title' && $currentDirection === 'desc' ? 'text-blue-600' : ($currentSort === 'title' ? 'text-gray-400' : 'text-gray-300 group-hover:text-gray-400') }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="{{ getSortUrl('status', $currentSort, $currentDirection) }}" class="flex items-center gap-1.5 cursor-pointer hover:text-gray-900 group transition-colors">
                                            <span>Status</span>
                                            <div class="flex flex-col -space-y-0.5">
                                                <svg class="w-2.5 h-2.5 {{ $currentSort === 'status' && $currentDirection === 'asc' ? 'text-blue-600' : ($currentSort === 'status' ? 'text-gray-400' : 'text-gray-300 group-hover:text-gray-400') }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                                <svg class="w-2.5 h-2.5 {{ $currentSort === 'status' && $currentDirection === 'desc' ? 'text-blue-600' : ($currentSort === 'status' ? 'text-gray-400' : 'text-gray-300 group-hover:text-gray-400') }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="{{ getSortUrl('created_at', $currentSort, $currentDirection) }}" class="flex items-center gap-1.5 cursor-pointer hover:text-gray-900 group transition-colors">
                                            <span>Date</span>
                                            <div class="flex flex-col -space-y-0.5">
                                                <svg class="w-2.5 h-2.5 {{ $currentSort === 'created_at' && $currentDirection === 'asc' ? 'text-blue-600' : ($currentSort === 'created_at' ? 'text-gray-400' : 'text-gray-300 group-hover:text-gray-400') }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                                <svg class="w-2.5 h-2.5 {{ $currentSort === 'created_at' && $currentDirection === 'desc' ? 'text-blue-600' : ($currentSort === 'created_at' ? 'text-gray-400' : 'text-gray-300 group-hover:text-gray-400') }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newsSubmissions as $submission)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">#{{ $submission->id }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-start gap-3">
                                                @if($submission->featured_image)
                                                    <img src="{{ asset('storage/' . $submission->featured_image) }}" alt="{{ $submission->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-medium text-gray-900 line-clamp-2">{{ $submission->title }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($submission->categories->count() > 0)
                                                <span class="text-sm text-gray-900">{{ $submission->categories->pluck('name')->join(', ') }}</span>
                                            @else
                                                <span class="text-sm text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-status-badge :status="$submission->status" />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $submission->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center gap-3 justify-end">
                                                <a href="{{ route('university.news.show', $submission) }}" 
                                                   class="p-1.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" 
                                                   title="View">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                </a>
                                                @if($submission->status !== 'rejected')
                                                    <a href="{{ route('university.news.edit', $submission) }}" 
                                                       class="p-1.5 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors" 
                                                       title="{{ in_array($submission->status, ['approved', 'published']) ? 'Edit (will resubmit for approval)' : 'Edit' }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                                @if(in_array($submission->status, ['draft', 'pending', 'rejected']))
                                                    <form action="{{ route('university.news.destroy', $submission) }}" 
                                                          method="POST" 
                                                          class="inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this submission?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="p-1.5 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded transition-colors" 
                                                                title="Delete">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination - Flowbite -->
                    @if($newsSubmissions->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            {{ $newsSubmissions->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                @else
                    <!-- Empty State - Flowbite -->
                    <div class="text-center py-16">
                        @if(request('search') || request('status'))
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No results found</h3>
                            <p class="text-sm text-gray-500 mb-6">
                                No news submissions match your search criteria.
                                @if(request('search'))
                                    Try adjusting your search term or 
                                @endif
                                @if(request('status'))
                                    try a different status filter.
                                @endif
                            </p>
                            <a href="{{ route('university.news.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear Filters
                            </a>
                        @else
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No news submissions</h3>
                            <p class="text-sm text-gray-500 mb-6">Get started by creating a new news submission.</p>
                            <a href="{{ route('university.news.create') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create New Submission
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-university-layout>

