<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('News Submissions Management') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <x-page-header 
                title="News Submissions" 
                description="Review, approve, or reject news submissions from universities."
            />

            <!-- Status Tabs and Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6 overflow-x-auto" aria-label="Tabs">
                        <a href="{{ route('admin.news.index') }}" 
                           class="@if(!request('status')) border-brand-500 text-brand-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            All
                            <span class="@if(!request('status')) bg-brand-100 text-brand-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
                                {{ $statusCounts['all'] }}
                            </span>
                        </a>
                        <a href="{{ route('admin.news.index', ['status' => 'pending']) }}" 
                           class="@if(request('status') === 'pending') border-orange-500 text-orange-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Pending Review
                            <span class="@if(request('status') === 'pending') bg-orange-100 text-orange-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
                                {{ $statusCounts['pending'] }}
                            </span>
                        </a>
                        <a href="{{ route('admin.news.index', ['status' => 'approved']) }}" 
                           class="@if(request('status') === 'approved') border-green-500 text-green-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Approved
                            <span class="@if(request('status') === 'approved') bg-green-100 text-green-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
                                {{ $statusCounts['approved'] }}
                            </span>
                        </a>
                        <a href="{{ route('admin.news.index', ['status' => 'rejected']) }}" 
                           class="@if(request('status') === 'rejected') border-red-500 text-red-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Rejected
                            <span class="@if(request('status') === 'rejected') bg-red-100 text-red-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
                                {{ $statusCounts['rejected'] }}
                            </span>
                        </a>
                        <a href="{{ route('admin.news.index', ['status' => 'published']) }}" 
                           class="@if(request('status') === 'published') border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Published
                            <span class="@if(request('status') === 'published') bg-blue-100 text-blue-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
                                {{ $statusCounts['published'] }}
                            </span>
                        </a>
                        <a href="{{ route('admin.news.index', ['status' => 'draft']) }}" 
                           class="@if(request('status') === 'draft') border-gray-500 text-gray-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Drafts
                            <span class="@if(request('status') === 'draft') bg-gray-200 text-gray-700 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium">
                                {{ $statusCounts['draft'] }}
                            </span>
                        </a>
                    </nav>
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
                                <span class="ml-2 px-2 py-0.5 bg-brand-100 text-brand-700 text-xs rounded-full font-medium">Active</span>
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
                                    <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" 
                                           name="search" 
                                           id="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Search title or excerpt..."
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                                </div>

                                <!-- University Filter -->
                                <div>
                                    <label for="university_id" class="block text-xs font-medium text-gray-700 mb-1">University</label>
                                    <select name="university_id" 
                                            id="university_id"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
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
                                    <label for="date_from" class="block text-xs font-medium text-gray-700 mb-1">From Date</label>
                                    <input type="date" 
                                           name="date_from" 
                                           id="date_from" 
                                           value="{{ request('date_from') }}"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                                </div>

                                <!-- Date To -->
                                <div>
                                    <label for="date_to" class="block text-xs font-medium text-gray-700 mb-1">To Date</label>
                                    <input type="date" 
                                           name="date_to" 
                                           id="date_to" 
                                           value="{{ request('date_to') }}"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Apply
                                </button>
                                <a href="{{ route('admin.news.index', request()->only('status')) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <x-alert type="success" class="mb-6" :dismissible="true">
                    {{ session('success') }}
                </x-alert>
            @endif

            <!-- News Submissions List -->
            @if($newsSubmissions->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No news submissions found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request()->has('search') || request()->has('university_id') || request()->has('date_from') || request()->has('date_to'))
                            Try adjusting your filters to find what you're looking for.
                        @else
                            Universities haven't submitted any news yet.
                        @endif
                    </p>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        News Article
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        University
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Submitted
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($newsSubmissions as $submission)
                                    <tr class="hover:bg-gray-50 transition-colors">
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
                                                    <p class="text-sm font-medium text-gray-900 truncate mb-1">
                                                        {{ $submission->title }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 line-clamp-2 mb-2">
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
                                        <td class="px-6 py-4 whitespace-nowrap align-top">
                                            <div class="text-sm text-gray-900">{{ $submission->university->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $submission->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap align-top">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 align-top">
                                            <div>{{ $submission->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $submission->created_at->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium align-top">
                                            <a href="{{ route('admin.news.show', $submission) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $newsSubmissions->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

