<x-university-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('University Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <x-page-header 
                title="Welcome, {{ Auth::user()->university->name ?? 'University User' }}!" 
                description="Create, manage, and track your news submissions in one place."
            >
                <x-slot name="actions">
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Article
                    </a>
                </x-slot>
            </x-page-header>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-stat-card
                    title="Draft Articles"
                    value="0"
                    color="yellow"
                    :icon="'<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\'></path></svg>'"
                />

                <x-stat-card
                    title="Pending Review"
                    value="0"
                    color="blue"
                    :icon="'<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z\'></path></svg>'"
                />

                <x-stat-card
                    title="Published"
                    value="0"
                    color="green"
                    :icon="'<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\'></path></svg>'"
                />
            </div>

            <!-- Getting Started -->
            <div class="bg-gradient-to-r from-brand-500 to-brand-700 rounded-xl shadow-lg p-8 text-white mb-8">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold mb-2">Ready to share your news?</h3>
                        <p class="text-blue-100 mb-4">
                            Start by creating your first news article. Once submitted, our team will review it and publish it to the AppliedHE Xtra! Xtra! platform.
                        </p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-white text-brand-700 rounded-lg font-semibold text-sm hover:bg-blue-50 transition-colors duration-150">
                            Create Your First Article
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 p-3 bg-brand-100 rounded-lg">
                            <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 mb-1">My Submissions</h4>
                            <p class="text-sm text-gray-600 mb-3">View and manage all your news articles</p>
                            <a href="#" class="text-sm text-brand-600 hover:text-brand-700 font-medium">
                                View all →
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 mb-1">Team Settings</h4>
                            <p class="text-sm text-gray-600 mb-3">Manage users and permissions</p>
                            <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                                Manage team →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-university-layout>

