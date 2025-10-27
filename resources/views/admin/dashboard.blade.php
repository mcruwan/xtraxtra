<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}</h1>
                <p class="mt-1 text-sm text-gray-600">Here's what's happening with your platform today.</p>
            </div>

            <!-- Universities Section -->
            <div class="mb-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Universities</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <x-stat-card
                        title="Pending Universities"
                        :value="$stats['pending_universities']"
                        color="orange"
                        icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        :link="$stats['pending_universities'] > 0 ? route('admin.universities.index', ['status' => 'pending']) : null"
                        :linkText="$stats['pending_universities'] > 0 ? 'Review' : null"
                    />

                    <x-stat-card
                        title="Active Universities"
                        :value="$stats['active_universities']"
                        color="green"
                        icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />

                    <x-stat-card
                        title="Total Universities"
                        :value="$stats['total_universities']"
                        color="blue"
                        icon="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                        :link="route('admin.universities.index')"
                        linkText="View all"
                    />
                </div>
            </div>

            <!-- News Submissions Section -->
            <div class="mb-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">News Submissions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <x-stat-card
                        title="Pending News"
                        :value="$stats['pending_news']"
                        color="orange"
                        icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        :link="$stats['pending_news'] > 0 ? route('admin.news.index', ['status' => 'pending']) : null"
                        :linkText="$stats['pending_news'] > 0 ? 'Review' : null"
                    />

                    <x-stat-card
                        title="Approved News"
                        :value="$stats['approved_news']"
                        color="green"
                        icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        :link="route('admin.news.index', ['status' => 'approved'])"
                        linkText="View"
                    />

                    <x-stat-card
                        title="Rejected News"
                        :value="$stats['rejected_news']"
                        color="red"
                        icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        :link="route('admin.news.index', ['status' => 'rejected'])"
                        linkText="View"
                    />

                    <x-stat-card
                        title="Total Submissions"
                        :value="$stats['total_news']"
                        color="blue"
                        icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        :link="route('admin.news.index')"
                        linkText="View all"
                    />
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Quick Actions</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.universities.index') }}" class="inline-flex items-center px-3 py-2 bg-brand-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Universities
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="inline-flex items-center px-3 py-2 bg-brand-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        News Submissions
                    </a>
                    <a href="{{ route('admin.universities.create') }}" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add University
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            @if($stats['pending_universities'] > 0 || $stats['pending_news'] > 0)
                <div class="mt-4 space-y-2">
                    @if($stats['pending_universities'] > 0)
                        <x-alert type="warning" :dismissible="true">
                            <span class="font-medium">{{ $stats['pending_universities'] }}</span> pending {{ Str::plural('university', $stats['pending_universities']) }} require your attention.
                        </x-alert>
                    @endif
                    
                    @if($stats['pending_news'] > 0)
                        <x-alert type="info" :dismissible="true">
                            <span class="font-medium">{{ $stats['pending_news'] }}</span> news {{ Str::plural('submission', $stats['pending_news']) }} awaiting review.
                            <a href="{{ route('admin.news.index', ['status' => 'pending']) }}" class="font-medium underline ml-1">
                                Review now
                            </a>
                        </x-alert>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

