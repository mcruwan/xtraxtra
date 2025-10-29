<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">
                {{ __('Admin Dashboard') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 0 0 0-1.414 0l-7 7-2 2a1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header with Flowbite styling -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}</h1>
                <p class="text-gray-600">Monitor platform activity, track performance, and manage your community.</p>
            </div>

            <!-- Alert Notifications (Flowbite Alerts) -->
            @if($stats['pending_universities'] > 0 || $stats['pending_news'] > 0)
                <div class="mb-8 space-y-4">
                    @if($stats['pending_universities'] > 0)
                        <div id="alert-universities" class="flex items-center p-4 mb-4 text-yellow-800 rounded-lg bg-yellow-50" role="alert">
                            <svg class="flex-shrink-0 w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div class="ms-3 text-sm font-medium flex-1">
                                <span class="font-bold">{{ $stats['pending_universities'] }}</span> pending {{ Str::plural('university', $stats['pending_universities']) }} require your attention.
                                <a href="{{ route('admin.universities.index', ['status' => 'pending']) }}" class="font-semibold underline hover:no-underline ms-2">Review now →</a>
                            </div>
                            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-universities" aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                    
                    @if($stats['pending_news'] > 0)
                        <div id="alert-news" class="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50" role="alert">
                            <svg class="flex-shrink-0 w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div class="ms-3 text-sm font-medium flex-1">
                                <span class="font-bold">{{ $stats['pending_news'] }}</span> news {{ Str::plural('submission', $stats['pending_news']) }} awaiting review.
                                <a href="{{ route('admin.news.index', ['status' => 'pending']) }}" class="font-semibold underline hover:no-underline ms-2">Review now →</a>
                            </div>
                            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-news" aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Key Metrics -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Platform Overview
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Total Universities -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-blue-900">Total Universities</h3>
                            <div class="p-2 bg-blue-200 rounded-lg">
                                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="text-4xl font-bold text-blue-900">{{ $stats['total_universities'] }}</span>
                        <p class="text-xs text-blue-700 mt-2">{{ $stats['active_universities'] }} active</p>
                    </div>

                    <!-- Total Submissions -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-purple-900">Total Submissions</h3>
                            <div class="p-2 bg-purple-200 rounded-lg">
                                <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="text-4xl font-bold text-purple-900">{{ $stats['total_news'] }}</span>
                        <p class="text-xs text-purple-700 mt-2">{{ $stats['pending_news'] }} pending review</p>
                    </div>

                    <!-- Published Content -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-green-900">Published</h3>
                            <div class="p-2 bg-green-200 rounded-lg">
                                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <span class="text-4xl font-bold text-green-900">{{ $stats['published_news'] }}</span>
                        <p class="text-xs text-green-700 mt-2">Live on platform</p>
                    </div>

                    <!-- Average Review Time -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-orange-900">Avg Review Time</h3>
                            <div class="p-2 bg-orange-200 rounded-lg">
                                <svg class="w-5 h-5 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        @if($stats['avg_review_hours'])
                            <span class="text-4xl font-bold text-orange-900">{{ $stats['avg_review_hours'] }}</span>
                            <p class="text-xs text-orange-700 mt-2">hours</p>
                        @else
                            <span class="text-lg text-orange-700">N/A</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                    Analytics & Trends
                </h2>
                
                <!-- Growth Trends Chart -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Platform Growth (Last 30 Days)</h3>
                    <div style="height: 300px;">
                        <canvas id="platformGrowthChart"></canvas>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Status Distribution Funnel -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Submission Flow</h3>
                        <div style="height: 300px;">
                            <canvas id="statusFlowChart"></canvas>
                        </div>
                    </div>

                    <!-- Category Analytics -->
                    @if($categoryStats->count() > 0)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Top Categories</h3>
                        <div style="height: 300px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- University Leaderboard -->
            @if($universityLeaderboard->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    University Leaderboard
                </h2>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Rank</th>
                                    <th scope="col" class="px-6 py-3">University</th>
                                    <th scope="col" class="px-6 py-3">Total Submissions</th>
                                    <th scope="col" class="px-6 py-3">Approved</th>
                                    <th scope="col" class="px-6 py-3">Approval Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($universityLeaderboard as $index => $university)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($index === 0)
                                                    <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @elseif($index === 1)
                                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @elseif($index === 2)
                                                    <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @else
                                                    <span class="text-gray-600 font-medium">{{ $index + 1 }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-medium text-gray-900">{{ $university['name'] }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-900 font-semibold">{{ $university['total_submissions'] }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-green-600 font-semibold">{{ $university['approved'] }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-[100px]">
                                                    <div class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: {{ $university['approval_rate'] }}%"></div>
                                                </div>
                                                <span class="text-xs font-medium text-gray-900">{{ $university['approval_rate'] }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistics Cards Section (Original Design) -->
            <div class="grid grid-cols-1 gap-6 mb-8">
                <!-- Universities Section -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Universities</h2>
                        <a href="{{ route('admin.universities.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                            View all
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
                        <!-- Pending Universities Card -->
                        <a href="{{ $stats['pending_universities'] > 0 ? route('admin.universities.index', ['status' => 'pending']) : '#' }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Pending</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['pending_universities'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Active Universities Card -->
                        <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Active</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['active_universities'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Total Universities Card -->
                        <a href="{{ route('admin.universities.index') }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Total</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['total_universities'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- News Submissions Section -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">News Submissions</h2>
                        <a href="{{ route('admin.news.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                            View all
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
                        <!-- Total News Card -->
                        <a href="{{ route('admin.news.index') }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Total</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['total_news'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Pending News Card -->
                        <a href="{{ $stats['pending_news'] > 0 ? route('admin.news.index', ['status' => 'pending']) : '#' }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Pending</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['pending_news'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Approved News Card -->
                        <a href="{{ route('admin.news.index', ['status' => 'approved']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Approved</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['approved_news'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Published News Card -->
                        <a href="{{ route('admin.news.index', ['status' => 'published']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Published</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['published_news'] ?? 0 }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Rejected News Card -->
                        <a href="{{ route('admin.news.index', ['status' => 'rejected']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Rejected</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['rejected_news'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Draft News Card -->
                        <a href="{{ route('admin.news.index', ['status' => 'draft']) }}" class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Drafts</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['draft_news'] ?? 0 }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.universities.index') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Manage Universities
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Review News Submissions
                        </a>
                        <a href="{{ route('admin.universities.create') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add University
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Platform Growth Trends Chart
        const growthCtx = document.getElementById('platformGrowthChart').getContext('2d');
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendData['dates']) !!},
                datasets: [
                    {
                        label: 'Universities',
                        data: {!! json_encode($trendData['universities']) !!},
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Submissions',
                        data: {!! json_encode($trendData['submissions']) !!},
                        borderColor: 'rgb(147, 51, 234)',
                        backgroundColor: 'rgba(147, 51, 234, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Status Flow Chart
        const flowCtx = document.getElementById('statusFlowChart').getContext('2d');
        new Chart(flowCtx, {
            type: 'bar',
            data: {
                labels: ['Draft', 'Pending', 'Approved', 'Published', 'Rejected'],
                datasets: [{
                    label: 'Submissions',
                    data: [
                        {{ $statusDistribution['draft'] }},
                        {{ $statusDistribution['pending'] }},
                        {{ $statusDistribution['approved'] }},
                        {{ $statusDistribution['published'] }},
                        {{ $statusDistribution['rejected'] }}
                    ],
                    backgroundColor: [
                        'rgba(156, 163, 175, 0.8)',
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                    borderColor: [
                        'rgb(156, 163, 175)',
                        'rgb(251, 191, 36)',
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(239, 68, 68)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y: {
                        ticks: {
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        @if($categoryStats->count() > 0)
        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoryStats->pluck('name')->toArray()) !!},
                datasets: [{
                    data: {!! json_encode($categoryStats->pluck('count')->toArray()) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(147, 51, 234, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
        @endif
    </script>
    @endpush
</x-admin-layout>
