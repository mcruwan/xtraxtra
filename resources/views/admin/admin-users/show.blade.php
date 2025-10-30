<x-admin-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $adminUser->name }}</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Admin User Details
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.admin-users.edit', $adminUser) }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit User
                        </a>
                        <a href="{{ route('admin.admin-users.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            <!-- User Details Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Main Info -->
                <div class="md:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">User Information</h2>
                    
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Full Name</label>
                            <p class="text-base text-gray-900 mt-1 font-medium">{{ $adminUser->name }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email Address</label>
                            <div class="mt-1 flex items-center gap-2">
                                <p class="text-base text-gray-900">{{ $adminUser->email }}</p>
                                <button onclick="copyToClipboard('{{ $adminUser->email }}')" class="text-gray-600 hover:text-gray-900" title="Copy email">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Role</label>
                            <div class="mt-1">
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $adminUser->role === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $adminUser->role)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status</label>
                            <div class="mt-1">
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $adminUser->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($adminUser->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Account Created</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $adminUser->created_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $adminUser->updated_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.admin-users.edit', $adminUser) }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit User
                        </a>

                        @if($adminUser->id !== auth()->id())
                            <form action="{{ route('admin.admin-users.destroy', $adminUser) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin user? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete User
                                </button>
                            </form>
                        @else
                            <div class="p-3 bg-gray-50 rounded-lg text-sm text-gray-600 text-center">
                                You cannot delete your own account
                            </div>
                        @endif

                        <a href="{{ route('admin.admin-users.index') }}" class="block w-full text-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Activity Info -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h2>
                
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">User ID</span>
                        <span class="text-gray-900 font-medium">#{{ $adminUser->id }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Email Verified</span>
                        <span class="text-gray-900 font-medium">
                            @if($adminUser->email_verified_at)
                                Yes ({{ $adminUser->email_verified_at->format('M d, Y') }})
                            @else
                                <span class="text-gray-400">Not verified</span>
                            @endif
                        </span>
                    </div>
                    @if($adminUser->university_id)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">University</span>
                            <span class="text-gray-900 font-medium">{{ $adminUser->university->name ?? 'N/A' }}</span>
                        </div>
                    @else
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-500">University</span>
                            <span class="text-gray-400 italic">Not assigned (admin user)</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Optionally show a toast notification
                alert('Copied to clipboard: ' + text);
            }, function(err) {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</x-admin-layout>

