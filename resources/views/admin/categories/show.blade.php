<x-admin-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $category->name }}</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Category Details and Associated Articles
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Category
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Category Details Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Main Info -->
                <div class="md:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Category Information</h2>
                    
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Name</label>
                            <p class="text-base text-gray-900 mt-1 font-medium">{{ $category->name }}</p>
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">URL Slug</label>
                            <div class="mt-1 flex items-center gap-2">
                                <code class="text-sm bg-gray-100 px-3 py-1 rounded text-gray-700">{{ $category->slug }}</code>
                                <button onclick="copyToClipboard('{{ $category->slug }}')" class="text-gray-600 hover:text-gray-900" title="Copy">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Description</label>
                            @if($category->description)
                                <p class="text-base text-gray-900 mt-1">{{ $category->description }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic mt-1">No description provided</p>
                            @endif
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Created</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $category->created_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $category->updated_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="space-y-4">
                    <!-- Articles Count -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Articles</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $category->newsSubmissions()->count() }}</p>
                            </div>
                            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Published Count -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Published</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $category->newsSubmissions()->where('status', 'published')->count() }}</p>
                            </div>
                            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-green-100">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Button -->
                    @if($category->newsSubmissions()->count() === 0)
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Category
                            </button>
                        </form>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800">This category has articles and cannot be deleted. Edit it instead.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Articles -->
            @if($recentSubmissions->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Articles ({{ $category->newsSubmissions()->count() }})</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">University</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Submitted</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($recentSubmissions as $submission)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.news.show', $submission) }}" class="text-blue-600 hover:text-blue-900 font-medium text-sm">
                                                {{ $submission->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-600">{{ $submission->university->name }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($submission->status === 'published') bg-green-100 text-green-800
                                                @elseif($submission->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($submission->status === 'approved') bg-blue-100 text-blue-800
                                                @elseif($submission->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $submission->submitted_at?->format('M d, Y') ?? 'Not submitted' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($category->newsSubmissions()->count() > 10)
                        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
                            <a href="{{ route('admin.news.index') }}?category={{ $category->id }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                View all {{ $category->newsSubmissions()->count() }} articles →
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-12">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No articles yet</h3>
                        <p class="mt-2 text-sm text-gray-600">Articles will appear here once universities submit news in this category.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Slug copied to clipboard!');
            }).catch(() => {
                alert('Failed to copy slug');
            });
        }
    </script>
</x-admin-layout>



