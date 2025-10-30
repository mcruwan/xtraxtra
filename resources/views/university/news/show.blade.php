<x-university-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header - Flowbite -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $newsSubmission->title }}</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('university.news.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                        @if(in_array($newsSubmission->status, ['draft', 'pending']))
                            <a href="{{ route('university.news.edit', $newsSubmission) }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Banner - Flowbite Alerts -->
                    @if($newsSubmission->status === 'rejected')
                        <div class="flex p-6 mb-6 text-red-800 rounded-lg bg-red-50 border border-red-200 shadow-sm" role="alert">
                            <svg class="flex-shrink-0 w-6 h-6 text-red-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-lg font-semibold text-red-800">Submission Rejected</h3>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Rejected
                                        </span>
                                    </div>
                                </div>
                                
                                @if($newsSubmission->rejection_reason)
                                    <div class="bg-white rounded-lg p-4 border border-red-200 mb-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-sm font-semibold text-red-900 flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Rejection Reason
                                            </h4>
                                            @if($newsSubmission->rejected_at)
                                                <div class="text-xs text-red-600">
                                                    Rejected on {{ $newsSubmission->rejected_at->format('M d, Y \a\t h:i A') }}
                                                    @if($newsSubmission->rejector)
                                                        by {{ $newsSubmission->rejector->name }}
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-sm text-red-800 leading-relaxed whitespace-pre-line">
                                            {{ $newsSubmission->rejection_reason }}
                                        </div>
                                    </div>
                                @endif

                                <div class="bg-red-100 rounded-lg p-4 border border-red-200">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-semibold text-red-900 mb-1">What's Next?</h4>
                                            <p class="text-sm text-red-800 mb-3">
                                                Please review the feedback above and make the necessary improvements to your article.
                                            </p>
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('university.news.edit', $newsSubmission) }}" 
                                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit & Resubmit
                                                </a>
                                                <a href="{{ route('university.news.create') }}" 
                                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Create New Article
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($newsSubmission->status === 'pending')
                        <div class="flex p-4 mb-6 text-yellow-800 rounded-lg bg-yellow-50 border border-yellow-200" role="alert">
                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="ml-3 text-sm font-medium">
                                This submission is pending review by the admin team.
                            </div>
                        </div>
                    @elseif($newsSubmission->status === 'approved')
                        <div class="flex p-4 mb-6 text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="ml-3 text-sm font-medium">
                                This submission has been approved and is ready to be published to WordPress.
                            </div>
                        </div>
                    @elseif($newsSubmission->status === 'published')
                        <div class="flex p-4 mb-6 text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="ml-3 text-sm font-medium">
                                This submission has been published to the WordPress site!
                                @if($newsSubmission->published_at)
                                    Published on {{ $newsSubmission->published_at->format('M d, Y \a\t h:i A') }}
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Excerpt - Flowbite Card -->
                    @if($newsSubmission->excerpt)
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Excerpt</h3>
                            <p class="text-gray-700 italic">{{ $newsSubmission->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Content - Flowbite Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">Content</h3>
                        <div class="prose max-w-none">
                            {!! $newsSubmission->content !!}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Featured Image - Flowbite Card -->
                    @if($newsSubmission->featured_image)
                        <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
                            <img src="{{ asset('storage/' . $newsSubmission->featured_image) }}" 
                                alt="{{ $newsSubmission->title }}" 
                                class="w-full h-auto rounded-lg">
                        </div>
                    @endif

                    <!-- Metadata - Flowbite Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                        <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide mb-4">Details</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                                <dd class="mt-1">
                                    <x-status-badge :status="$newsSubmission->status" />
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Author</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $newsSubmission->user?->name ?? 'Unknown' }}</dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $newsSubmission->created_at?->format('M d, Y \a\t h:i A') ?? 'N/A' }}</dd>
                            </div>

                            @if($newsSubmission->submitted_at)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Submitted</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $newsSubmission->submitted_at->format('M d, Y \a\t h:i A') }}</dd>
                                </div>
                            @endif

                            @if($newsSubmission->approved_at && $newsSubmission->approver)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $newsSubmission->approver?->name ?? 'Unknown' }}
                                        <span class="text-gray-500">on {{ $newsSubmission->approved_at->format('M d, Y') }}</span>
                                    </dd>
                                </div>
                            @endif

                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Slug</dt>
                                <dd class="mt-1 text-sm text-gray-600 font-mono bg-gray-50 px-2 py-1 rounded">{{ $newsSubmission->slug }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Categories - Flowbite Card -->
                    @if($newsSubmission->categories->count() > 0)
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                            <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide mb-3">Categories</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($newsSubmission->categories as $category)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Tags - Flowbite Card -->
                    @if($newsSubmission->tags->count() > 0)
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                            <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide mb-3">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($newsSubmission->tags as $tag)
                                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions - Flowbite Card -->
                    @if(in_array($newsSubmission->status, ['draft', 'pending', 'rejected']))
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                            <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide mb-3">Actions</h3>
                            <div class="space-y-2">
                                @if(in_array($newsSubmission->status, ['draft', 'pending']))
                                    <a href="{{ route('university.news.edit', $newsSubmission) }}" 
                                        class="w-full inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Submission
                                    </a>
                                @endif

                                <form action="{{ route('university.news.destroy', $newsSubmission) }}" method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this submission?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Submission
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-university-layout>

