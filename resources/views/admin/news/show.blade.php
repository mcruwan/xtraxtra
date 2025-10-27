<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review News Submission') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.news.index') }}" 
                   class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to News Submissions
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <x-alert type="success" class="mb-6" :dismissible="true">
                    {{ session('success') }}
                </x-alert>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Article Content -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Status Banner -->
                        @if($newsSubmission->status === 'pending')
                            <div class="bg-orange-50 border-l-4 border-orange-400 p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-orange-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-orange-800">This submission is pending your review</p>
                                </div>
                            </div>
                        @elseif($newsSubmission->status === 'approved')
                            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-green-800">This submission has been approved</p>
                                        @if($newsSubmission->approver)
                                            <p class="text-xs text-green-700 mt-1">
                                                Approved by {{ $newsSubmission->approver->name }} on {{ $newsSubmission->approved_at->format('M d, Y \a\t h:i A') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($newsSubmission->status === 'rejected')
                            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-red-800">This submission has been rejected</p>
                                        @if($newsSubmission->rejection_reason)
                                            <p class="text-sm text-red-700 mt-2">
                                                <span class="font-medium">Reason:</span> {{ $newsSubmission->rejection_reason }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="p-6">
                            <!-- Featured Image -->
                            @if($newsSubmission->featured_image)
                                <div class="mb-6">
                                    <img src="{{ Storage::url($newsSubmission->featured_image) }}" 
                                         alt="{{ $newsSubmission->title }}"
                                         class="w-full rounded-lg shadow-md">
                                </div>
                            @endif

                            <!-- Title -->
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                                {{ $newsSubmission->title }}
                            </h1>

                            <!-- Excerpt -->
                            @if($newsSubmission->excerpt)
                                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                    <p class="text-lg text-gray-700 italic">
                                        {{ $newsSubmission->excerpt }}
                                    </p>
                                </div>
                            @endif

                            <!-- Content -->
                            <div class="prose prose-lg max-w-none">
                                {!! nl2br(e($newsSubmission->content)) !!}
                            </div>

                            <!-- Categories and Tags -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex flex-wrap gap-6">
                                    @if($newsSubmission->categories->isNotEmpty())
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-500 mb-2">Categories</h3>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($newsSubmission->categories as $category)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($newsSubmission->tags->isNotEmpty())
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-500 mb-2">Tags</h3>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($newsSubmission->tags as $tag)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                        #{{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Action Buttons -->
                    @if($newsSubmission->status === 'pending')
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Actions</h3>
                            
                            <!-- Approve Button -->
                            <form action="{{ route('admin.news.approve', $newsSubmission) }}" method="POST" class="mb-3">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to approve this news submission?')"
                                        class="w-full inline-flex justify-center items-center px-4 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Approve Submission
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <button type="button"
                                    onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                                    class="w-full inline-flex justify-center items-center px-4 py-3 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Reject Submission
                            </button>
                        </div>
                    @endif

                    <!-- Submission Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Submission Details</h3>
                        
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">University</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $newsSubmission->university->name }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Submitted By</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $newsSubmission->user->name }}</dd>
                                <dd class="text-xs text-gray-500">{{ $newsSubmission->user->email }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($newsSubmission->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            Pending Review
                                        </span>
                                    @elseif($newsSubmission->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @elseif($newsSubmission->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @elseif($newsSubmission->status === 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($newsSubmission->status) }}
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $newsSubmission->created_at->format('M d, Y') }}</dd>
                                <dd class="text-xs text-gray-500">{{ $newsSubmission->created_at->diffForHumans() }}</dd>
                            </div>

                            @if($newsSubmission->submitted_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Submitted</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $newsSubmission->submitted_at->format('M d, Y') }}</dd>
                                    <dd class="text-xs text-gray-500">{{ $newsSubmission->submitted_at->diffForHumans() }}</dd>
                                </div>
                            @endif

                            @if($newsSubmission->approved_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Approved</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $newsSubmission->approved_at->format('M d, Y') }}</dd>
                                    <dd class="text-xs text-gray-500">{{ $newsSubmission->approved_at->diffForHumans() }}</dd>
                                </div>
                            @endif

                            @if($newsSubmission->wordpress_post_id)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">WordPress Post ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">#{{ $newsSubmission->wordpress_post_id }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
                        
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Word Count</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ str_word_count($newsSubmission->content) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Categories</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $newsSubmission->categories->count() }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Tags</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $newsSubmission->tags->count() }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50">
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form action="{{ route('admin.news.reject', $newsSubmission) }}" method="POST">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                                        Reject Submission
                                    </h3>
                                    <div>
                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                            Rejection Reason <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="rejection_reason" 
                                                  id="rejection_reason" 
                                                  rows="4"
                                                  required
                                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                                  placeholder="Please provide a detailed reason for rejecting this submission..."></textarea>
                                        <p class="mt-2 text-sm text-gray-500">
                                            This reason will be visible to the university user who submitted the article.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" 
                                    class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto">
                                Reject Submission
                            </button>
                            <button type="button"
                                    onclick="document.getElementById('rejectModal').classList.add('hidden')"
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

