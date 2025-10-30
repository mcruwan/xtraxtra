<x-university-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('University Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section - Flowbite Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        @if(Auth::user()->university->logo)
                            <img src="{{ Storage::url(Auth::user()->university->logo) }}" 
                                 alt="{{ Auth::user()->university->name }} logo" 
                                 class="h-16 w-auto object-contain">
                        @else
                            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                                Welcome, {{ Auth::user()->university->name ?? 'University User' }}!
                            </h1>
                            <p class="mt-2 text-sm text-gray-600">
                                Track your submissions, monitor performance, and gain insights into your news content.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Profile Settings
                        </a>
                        <a href="{{ route('university.news.create') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Article
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid - Flowbite Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-8">
                <!-- Total Card -->
                <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Total</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['total_news'] }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Draft Articles Card -->
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

                <!-- Pending Review Card -->
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
                            <p class="text-xl font-bold text-gray-900">{{ $stats['approved'] ?? 0 }}</p>
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
                            <p class="text-xl font-bold text-gray-900">{{ $stats['rejected'] ?? 0 }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Getting Started - Flowbite Alert -->
            @if($stats['total_news'] === 0)
                <div id="info-alert" class="flex p-4 mb-6 text-blue-800 rounded-lg bg-blue-50 border border-blue-200" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-blue-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ml-3 flex-1">
                        <h3 class="text-xl font-semibold mb-2">Ready to share your news?</h3>
                        <div class="mt-2 mb-4 text-sm">
                            Start by creating your first news article. Once submitted, our team will review it and publish it to the AppliedHE Xtra! Xtra! platform.
                        </div>
                        <div class="flex">
                            <a href="{{ route('university.news.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Create Your First Article
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if($stats['total_news'] > 0)
                <!-- Analytics Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Analytics & Insights
                    </h2>
                    
                    <!-- Key Metrics Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Approval Rate -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-green-900">Approval Rate</h3>
                                <div class="p-2 bg-green-200 rounded-lg">
                                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <span class="text-4xl font-bold text-green-900">{{ $stats['approval_rate'] }}%</span>
                            </div>
                            <p class="text-xs text-green-700 mt-2">Of reviewed submissions</p>
                            <div class="mt-4 bg-green-200 rounded-full h-2 overflow-hidden">
                                <div class="bg-green-600 h-2 transition-all duration-1000" style="width: {{ $stats['approval_rate'] }}%"></div>
                            </div>
                        </div>

                        <!-- This Month's Submissions -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-blue-900">This Month</h3>
                                <div class="p-2 bg-blue-200 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <span class="text-4xl font-bold text-blue-900">{{ $stats['this_month_submissions'] }}</span>
                            </div>
                            <p class="text-xs text-blue-700 mt-2">Submissions this month</p>
                        </div>

                        <!-- Success Score -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-purple-900">Total Published</h3>
                                <div class="p-2 bg-purple-200 rounded-lg" style="background-color: rgb(233 213 255);">
                                    <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <span class="text-4xl font-bold text-purple-900">{{ $stats['published'] }}</span>
                                <span class="text-lg font-semibold text-purple-700 ml-1">/ {{ $stats['total_news'] }}</span>
                            </div>
                            <p class="text-xs text-purple-700 mt-2">Articles live on platform</p>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <!-- Submission Trends Chart - Full Width -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            Submission Trends (Last 30 Days)
                        </h3>
                        <div style="height: 300px;">
                            <canvas id="submissionTrendsChart"></canvas>
                        </div>
                    </div>

                </div>
            @endif

            <!-- Recent News Submissions - Flowbite Table -->
            @if($recentNews->count() > 0)
                <div class="bg-white rounded-lg shadow border border-gray-200 mb-8 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Submissions</h3>
                            <a href="{{ route('university.news.index') }}" class="text-sm font-medium text-blue-600 hover:underline">
                                View all →
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Article</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Created</th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentNews as $news)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($news->featured_image)
                                                    <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $news->title }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-status-badge :status="$news->status" size="sm" />
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($news->categories->count() > 0)
                                                <span class="text-xs text-gray-500">{{ $news->categories->first()->name }}</span>
                                            @else
                                                <span class="text-xs text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500">
                                            {{ $news->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('university.news.show', $news) }}" 
                                               class="p-1.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors inline-flex items-center gap-2" 
                                               title="View">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($stats['total_news'] > 0)
    @push('scripts')
    <script>
        // Submission Trends Chart
        const trendsCtx = document.getElementById('submissionTrendsChart').getContext('2d');
        new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($trendData)) !!},
                datasets: [{
                    label: 'Submissions',
                    data: {!! json_encode(array_values($trendData)) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
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

    </script>
    @endpush
    @endif
</x-university-layout>
