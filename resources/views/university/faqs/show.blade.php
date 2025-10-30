<x-university-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header - Flowbite -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">FAQ Details</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            View FAQ information
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('university.faqs.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to FAQs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article Content Card - Flowbite -->
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                <div class="p-6 space-y-6">
                    <!-- Question as Title -->
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $faq->question }}</h1>
                    </div>

                    <!-- Answer Content -->
                    <div>
                        <div class="text-base text-gray-700 prose max-w-none faq-answer-content">{!! $faq->answer !!}</div>
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
    </style>
</x-university-layout>

