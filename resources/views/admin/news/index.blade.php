<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('News Submissions Management') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Review, approve, or reject news submissions from universities.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message - Flowbite Alert -->
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

            <!-- Status Tabs and Filters - Flowbite Tabs -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden mb-6">
                <div class="border-b border-gray-200">
                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 overflow-x-auto">
                        <li class="me-2">
                            <a href="{{ route('admin.news.index') }}" 
                               class="inline-block p-4 {{ !request('status') ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" 
                               aria-current="{{ !request('status') ? 'page' : 'false' }}">
                                All
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ !request('status') ? 'text-blue-800 bg-blue-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['all'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.news.index', ['status' => 'pending']) }}" 
                               class="inline-block p-4 {{ request('status') === 'pending' ? 'text-orange-600 border-b-2 border-orange-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" 
                               aria-current="{{ request('status') === 'pending' ? 'page' : 'false' }}">
                                Pending Review
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'pending' ? 'text-orange-800 bg-orange-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['pending'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.news.index', ['status' => 'approved']) }}" 
                               class="inline-block p-4 {{ request('status') === 'approved' ? 'text-green-600 border-b-2 border-green-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" 
                               aria-current="{{ request('status') === 'approved' ? 'page' : 'false' }}">
                                Approved
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'approved' ? 'text-green-800 bg-green-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['approved'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.news.index', ['status' => 'rejected']) }}" 
                               class="inline-block p-4 {{ request('status') === 'rejected' ? 'text-red-600 border-b-2 border-red-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" 
                               aria-current="{{ request('status') === 'rejected' ? 'page' : 'false' }}">
                                Rejected
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'rejected' ? 'text-red-800 bg-red-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['rejected'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.news.index', ['status' => 'published']) }}" 
                               class="inline-block p-4 {{ request('status') === 'published' ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" 
                               aria-current="{{ request('status') === 'published' ? 'page' : 'false' }}">
                                Published
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'published' ? 'text-blue-800 bg-blue-200' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['published'] }}
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('admin.news.index', ['status' => 'draft']) }}" 
                               class="inline-block p-4 {{ request('status') === 'draft' ? 'text-gray-600 border-b-2 border-gray-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" 
                               aria-current="{{ request('status') === 'draft' ? 'page' : 'false' }}">
                                Drafts
                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold {{ request('status') === 'draft' ? 'text-gray-800 bg-gray-300' : 'text-gray-800 bg-gray-200' }} rounded-full">
                                    {{ $statusCounts['draft'] }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Compact Filters -->
                <div x-data="{ filtersOpen: {{ request()->hasAny(['search', 'university_id', 'date_from', 'date_to']) ? 'true' : 'false' }} }" class="border-b border-gray-200">
                    <!-- Filter Toggle Button -->
                    <button @click="filtersOpen = !filtersOpen" 
                            type="button"
                            class="w-full px-6 py-3 flex items-center justify-between text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <span>Filters</span>
                            @if(request()->hasAny(['search', 'university_id', 'date_from', 'date_to']))
                                <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">Active</span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="filtersOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Collapsible Filter Form -->
                    <div x-show="filtersOpen" 
                         x-collapse
                         class="px-6 py-6 bg-gray-50">
                        <form method="GET" action="{{ route('admin.news.index') }}">
                            <!-- Keep status filter if present -->
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                <!-- Search -->
                                <div>
                                    <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search</label>
                                    <input type="text" 
                                           name="search" 
                                           id="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Search title or excerpt..."
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>

                                <!-- University Filter -->
                                <div>
                                    <label for="university_id" class="block mb-2 text-sm font-medium text-gray-900">University</label>
                                    <select name="university_id" 
                                            id="university_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">All Universities</option>
                                        @foreach($universities as $university)
                                            <option value="{{ $university->id }}" {{ request('university_id') == $university->id ? 'selected' : '' }}>
                                                {{ $university->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date From -->
                                <div>
                                    <label for="date_from" class="block mb-2 text-sm font-medium text-gray-900">From Date</label>
                                    <input type="date" 
                                           name="date_from" 
                                           id="date_from" 
                                           value="{{ request('date_from') }}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>

                                <!-- Date To -->
                                <div>
                                    <label for="date_to" class="block mb-2 text-sm font-medium text-gray-900">To Date</label>
                                    <input type="date" 
                                           name="date_to" 
                                           id="date_to" 
                                           value="{{ request('date_to') }}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Apply
                                </button>
                                <a href="{{ route('admin.news.index', request()->only('status')) }}" 
                                   class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- News Submissions List - Flowbite Table -->
            @if($newsSubmissions->isEmpty())
                <div class="bg-white rounded-lg shadow-md border border-gray-200 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No news submissions found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request()->has('search') || request()->has('university_id') || request()->has('date_from') || request()->has('date_to'))
                            Try adjusting your filters to find what you're looking for.
                        @else
                            Universities haven't submitted any news yet.
                        @endif
                    </p>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 min-w-[300px]">
                                        News Article
                                    </th>
                                    <th scope="col" class="px-6 py-3 min-w-[150px] max-w-[200px]">
                                        University
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-32">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-36">
                                        Submitted
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right w-32">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newsSubmissions as $submission)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 align-top">
                                            <div class="flex items-start gap-4">
                                                @if($submission->featured_image)
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ Storage::url($submission->featured_image) }}" 
                                                             alt="{{ $submission->title }}"
                                                             class="w-20 h-20 rounded-lg object-cover">
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 w-20 h-20 rounded-lg bg-gray-200 flex items-center justify-center">
                                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 break-words mb-1">
                                                        {{ $submission->title }}
                                                    </p>
                                                    @if($submission->is_revision && $submission->previous_status)
                                                        <div class="mb-2">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                </svg>
                                                                Edited (Was {{ ucfirst($submission->previous_status) }})
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <p class="text-sm text-gray-500 line-clamp-2 mb-2 break-words">
                                                        {{ Str::limit($submission->excerpt, 100) }}
                                                    </p>
                                                    <div class="flex flex-wrap gap-1.5">
                                                        @foreach($submission->categories->take(2) as $category)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $category->name }}
                                                            </span>
                                                        @endforeach
                                                        @if($submission->categories->count() > 2)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                                +{{ $submission->categories->count() - 2 }} more
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 align-top max-w-[200px]">
                                            <div class="text-sm text-gray-900 break-words">{{ $submission->university->name }}</div>
                                            <div class="text-sm text-gray-500 break-words">{{ $submission->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            @if($submission->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Pending
                                                </span>
                                            @elseif($submission->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Approved
                                                </span>
                                            @elseif($submission->status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Rejected
                                                </span>
                                            @elseif($submission->status === 'published')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Published
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ ucfirst($submission->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 align-top">
                                            <div class="break-words">{{ $submission->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-400 break-words">{{ $submission->created_at->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-right align-top">
                                            <a href="{{ route('admin.news.show', $submission) }}" 
                                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination - Flowbite Pagination -->
                    <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $newsSubmissions->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

