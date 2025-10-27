<x-university-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <x-page-header title="News Submissions" description="Manage your university's news submissions and articles">
                <x-slot name="actions">
                    <a href="{{ route('university.news.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Submission
                    </a>
                </x-slot>
            </x-page-header>

            <!-- Success Message -->
            @if(session('success'))
                <x-alert type="success" dismissible class="mb-6">
                    {{ session('success') }}
                </x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error" dismissible class="mb-6">
                    {{ session('error') }}
                </x-alert>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <x-stat-card 
                    title="Total" 
                    :value="$stats['total']" 
                    color="blue"
                    icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
                
                <x-stat-card 
                    title="Drafts" 
                    :value="$stats['drafts']" 
                    color="gray"
                    icon="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                    link="{{ route('university.news.index', ['status' => 'draft']) }}"
                    linkText="View drafts"
                />
                
                <x-stat-card 
                    title="Pending" 
                    :value="$stats['pending']" 
                    color="yellow"
                    icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    link="{{ route('university.news.index', ['status' => 'pending']) }}"
                    linkText="View pending"
                />
                
                <x-stat-card 
                    title="Approved" 
                    :value="$stats['approved']" 
                    color="green"
                    icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    link="{{ route('university.news.index', ['status' => 'approved']) }}"
                    linkText="View approved"
                />
                
                <x-stat-card 
                    title="Published" 
                    :value="$stats['published']" 
                    color="indigo"
                    icon="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                    link="{{ route('university.news.index', ['status' => 'published']) }}"
                    linkText="View published"
                />
                
                <x-stat-card 
                    title="Rejected" 
                    :value="$stats['rejected']" 
                    color="red"
                    icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    link="{{ route('university.news.index', ['status' => 'rejected']) }}"
                    linkText="View rejected"
                />
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                <form method="GET" action="{{ route('university.news.index') }}" class="flex items-center gap-4">
                    <div class="flex-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" onchange="this.form.submit()">
                            <option value="">All Submissions</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Drafts</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    @if(request('status'))
                        <div class="pt-7">
                            <a href="{{ route('university.news.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                                Clear Filter
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- News Submissions List -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                @if($newsSubmissions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($newsSubmissions as $submission)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($submission->featured_image)
                                                    <img src="{{ asset('storage/' . $submission->featured_image) }}" alt="{{ $submission->title }}" class="w-12 h-12 rounded object-cover mr-3">
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($submission->title, 50) }}</div>
                                                    @if($submission->categories->count() > 0)
                                                        <div class="text-xs text-gray-500">
                                                            {{ $submission->categories->pluck('name')->join(', ') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $submission->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-status-badge :status="$submission->status" />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('university.news.show', $submission) }}" class="text-brand-600 hover:text-brand-900">View</a>
                                            @if(in_array($submission->status, ['draft', 'pending']))
                                                <a href="{{ route('university.news.edit', $submission) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            @endif
                                            @if(in_array($submission->status, ['draft', 'pending', 'rejected']))
                                                <form action="{{ route('university.news.destroy', $submission) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this submission?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $newsSubmissions->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No news submissions</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new news submission.</p>
                        <div class="mt-6">
                            <a href="{{ route('university.news.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-md hover:bg-brand-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create New Submission
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-university-layout>

