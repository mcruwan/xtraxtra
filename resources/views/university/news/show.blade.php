<x-university-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <x-page-header :title="$newsSubmission->title">
                <x-slot name="actions">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('university.news.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                        @if(in_array($newsSubmission->status, ['draft', 'pending']))
                            <a href="{{ route('university.news.edit', $newsSubmission) }}" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        @endif
                    </div>
                </x-slot>
            </x-page-header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Banner -->
                    @if($newsSubmission->status === 'rejected')
                        <x-alert type="error">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">This submission was rejected</h3>
                                    @if($newsSubmission->rejection_reason)
                                        <p class="mt-2 text-sm text-red-700">
                                            <strong>Reason:</strong> {{ $newsSubmission->rejection_reason }}
                                        </p>
                                    @endif
                                    <p class="mt-2 text-sm text-red-700">
                                        You can edit and resubmit this submission for review.
                                    </p>
                                </div>
                            </div>
                        </x-alert>
                    @elseif($newsSubmission->status === 'pending')
                        <x-alert type="warning">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-yellow-700">This submission is pending review by the admin team.</p>
                            </div>
                        </x-alert>
                    @elseif($newsSubmission->status === 'approved')
                        <x-alert type="success">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-green-700">
                                    This submission has been approved and is ready to be published to WordPress.
                                </p>
                            </div>
                        </x-alert>
                    @elseif($newsSubmission->status === 'published')
                        <x-alert type="success">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <p class="text-sm text-green-700">
                                    This submission has been published to the WordPress site!
                                    @if($newsSubmission->published_at)
                                        Published on {{ $newsSubmission->published_at->format('M d, Y \a\t h:i A') }}
                                    @endif
                                </p>
                            </div>
                        </x-alert>
                    @endif

                    <!-- Excerpt -->
                    @if($newsSubmission->excerpt)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Excerpt</h3>
                            <p class="text-gray-700 italic">{{ $newsSubmission->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">Content</h3>
                        <div class="prose max-w-none">
                            {!! $newsSubmission->content !!}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Featured Image -->
                    @if($newsSubmission->featured_image)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <img src="{{ asset('storage/' . $newsSubmission->featured_image) }}" 
                                alt="{{ $newsSubmission->title }}" 
                                class="w-full h-auto rounded-lg">
                        </div>
                    @endif

                    <!-- Metadata -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
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

                    <!-- Categories -->
                    @if($newsSubmission->categories->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide mb-3">Categories</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($newsSubmission->categories as $category)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Tags -->
                    @if($newsSubmission->tags->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide mb-3">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($newsSubmission->tags as $tag)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    @if(in_array($newsSubmission->status, ['draft', 'pending', 'rejected']))
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide mb-3">Actions</h3>
                            <div class="space-y-2">
                                @if(in_array($newsSubmission->status, ['draft', 'pending']))
                                    <a href="{{ route('university.news.edit', $newsSubmission) }}" 
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-md hover:bg-brand-700 transition">
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
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
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

