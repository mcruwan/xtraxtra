<x-admin-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">FAQ Details</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            View and manage FAQ information
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit FAQ
                        </a>
                        <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if ($message = Session::get('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                    </div>
                </div>
            @endif

            <!-- FAQ Details Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Main Info -->
                <div class="md:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">FAQ Information</h2>
                    
                    <div class="space-y-4">
                        <!-- University -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">University</label>
                            <p class="text-base text-gray-900 mt-1 font-medium">{{ $faq->university->name }}</p>
                        </div>

                        <!-- Question -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Question</label>
                            <p class="text-base text-gray-900 mt-1 font-medium">{{ $faq->question }}</p>
                        </div>

                        <!-- Answer -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Answer</label>
                            <div class="text-base text-gray-900 mt-1 prose max-w-none faq-answer-content">{!! $faq->answer !!}</div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Created</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $faq->created_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $faq->updated_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="space-y-4">
                    <!-- Status -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2 {{ $faq->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-center w-12 h-12 rounded-lg {{ $faq->is_active ? 'bg-green-100' : 'bg-gray-100' }}">
                                <svg class="w-6 h-6 {{ $faq->is_active ? 'text-green-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Order -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Display Order</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $faq->order }}</p>
                            </div>
                            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <div class="space-y-2">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit FAQ
                            </a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete FAQ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .faq-answer-content h2 {
            font-size: 1.5rem !important;
            font-weight: 600 !important;
            margin-bottom: 1rem !important;
            color: #1f2937 !important;
        }
        
        .faq-answer-content h3 {
            font-size: 1.125rem !important;
            font-weight: 600 !important;
            margin-bottom: 0.5rem !important;
            color: #111827 !important;
        }
        
        .faq-answer-content p {
            margin-bottom: 1.5rem !important;
            color: #4b5563 !important;
            line-height: 1.7 !important;
        }
        
        .faq-answer-content p:last-child {
            margin-bottom: 0 !important;
        }
        
        .faq-answer-content strong {
            font-weight: 600 !important;
        }
        
        .faq-answer-content div[style*="background-color"] {
            display: block !important;
            margin-bottom: 1.25rem !important;
            padding: 1rem !important;
            border-radius: 0.375rem !important;
        }
        
        .faq-answer-content div[style*="background-color"]:last-child {
            margin-bottom: 0 !important;
        }
        
        .faq-answer-content div[style*="display: grid"] {
            display: grid !important;
            gap: 1.25rem !important;
            margin-bottom: 1.5rem !important;
        }
        
        .faq-answer-content div[style*="border-left"] {
            border-left-width: 4px !important;
        }
    </style>
</x-admin-layout>

