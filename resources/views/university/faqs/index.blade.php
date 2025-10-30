<x-university-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header - Flowbite -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">FAQs</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Frequently asked questions and helpful articles for your reference
                        </p>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages - Flowbite Alerts -->
            @if(session('success'))
                <div id="success-alert" class="flex p-4 mb-6 text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-green-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div id="error-alert" class="flex p-4 mb-6 text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-red-600 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Search - Flowbite Form -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
                <form method="GET" action="{{ route('university.faqs.index') }}" class="flex gap-4">
                    <div class="flex-1">
                        <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search questions or answers..."
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                            </svg>
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- FAQs List - Flowbite Accordion -->
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                @if($faqs->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($faqs as $faq)
                            <a href="{{ route('university.faqs.show', $faq) }}" class="block p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $faq->question }}</h3>
                                        <div class="text-sm text-gray-600 line-clamp-3">{!! strip_tags($faq->answer) !!}</div>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination - Flowbite -->
                    @if($faqs->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            {{ $faqs->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                @else
                    <!-- Empty State - Flowbite -->
                    <div class="text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No FAQs found</h3>
                        <p class="text-sm text-gray-500 mb-6">
                            @if(request('search'))
                                No FAQs match your search criteria.
                            @else
                                No FAQs available at the moment.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-university-layout>

