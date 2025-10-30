<x-admin-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $universityUser->name }}</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            University User Details
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.university-users.edit', $universityUser) }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit User
                        </a>
                        <a href="{{ route('admin.university-users.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-colors">
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
                    @if(session('generated_password'))
                        <div class="mt-3 p-3 bg-green-100 rounded border border-green-300">
                            <p class="text-sm font-medium text-green-900 mb-1">Generated Password:</p>
                            <div class="flex items-center gap-2">
                                <code class="text-sm bg-white px-3 py-2 rounded border border-green-300 font-mono text-green-800 flex-1" id="generated-password">{{ session('generated_password') }}</code>
                                <button onclick="copyPassword()" class="px-3 py-2 text-sm font-medium text-green-700 bg-green-200 rounded hover:bg-green-300">
                                    Copy
                                </button>
                            </div>
                            <p class="text-xs text-green-700 mt-2">⚠️ Please save this password securely. You won't be able to see it again.</p>
                        </div>
                    @endif
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Main Info -->
                <div class="md:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">User Information</h2>
                    
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Full Name</label>
                            <p class="text-base text-gray-900 mt-1 font-medium">{{ $universityUser->name }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email Address</label>
                            <div class="mt-1 flex items-center gap-2">
                                <p class="text-base text-gray-900">{{ $universityUser->email }}</p>
                                <button onclick="copyToClipboard('{{ $universityUser->email }}')" class="text-gray-600 hover:text-gray-900" title="Copy email">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- University -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">University</label>
                            <div class="mt-1">
                                @if($universityUser->university)
                                    <a href="{{ route('admin.universities.show', $universityUser->university) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        {{ $universityUser->university->name }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Not assigned</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status</label>
                            <div class="mt-1">
                                <span class="px-3 py-1 text-sm font-medium rounded-full 
                                    {{ $universityUser->status === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($universityUser->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($universityUser->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Account Created</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $universityUser->created_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $universityUser->updated_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.university-users.edit', $universityUser) }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit User
                        </a>

                        <!-- Password Reset Form -->
                        <div x-data="{ showPasswordReset: false }" class="space-y-3">
                            <button @click="showPasswordReset = !showPasswordReset" type="button" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                Reset Password
                            </button>

                            <div x-show="showPasswordReset" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <form action="{{ route('admin.university-users.reset-password', $universityUser) }}" method="POST">
                                    @csrf
                                    <div class="space-y-3">
                                        <div>
                                            <label for="reset_password" class="block mb-1 text-xs font-medium text-gray-700">New Password</label>
                                            <input type="password" id="reset_password" name="password" required minlength="8" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label for="reset_password_confirmation" class="block mb-1 text-xs font-medium text-gray-700">Confirm Password</label>
                                            <input type="password" id="reset_password_confirmation" name="password_confirmation" required minlength="8" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                            Reset Password
                                        </button>
                                        <button type="button" @click="showPasswordReset = false" class="w-full px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Generate Random Password -->
                        <form action="{{ route('admin.university-users.generate-password', $universityUser) }}" method="POST" onsubmit="return confirm('Generate a random password for this user?');">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Generate Random Password
                            </button>
                        </form>

                        <form action="{{ route('admin.university-users.destroy', $universityUser) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete User
                            </button>
                        </form>

                        <a href="{{ route('admin.university-users.index') }}" class="block w-full text-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Submissions -->
            @if($recentSubmissions->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent News Submissions</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Title</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSubmissions as $submission)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.news.show', $submission) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                                {{ \Illuminate\Support\Str::limit($submission->title, 50) }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500">
                                            {{ $submission->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Copied to clipboard: ' + text);
            }, function(err) {
                console.error('Failed to copy: ', err);
            });
        }

        function copyPassword() {
            const passwordElement = document.getElementById('generated-password');
            if (passwordElement) {
                copyToClipboard(passwordElement.textContent);
            }
        }
    </script>
</x-admin-layout>

