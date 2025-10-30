<x-admin-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">University Users</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Manage all university user accounts
                        </p>
                    </div>
                    <a href="{{ route('admin.university-users.create') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New User
                    </a>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('admin.university-users.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search</label>
                            <input 
                                type="text" 
                                id="search" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search by name, email, or university..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>

                        <!-- University Filter -->
                        <div>
                            <label for="university_id" class="block mb-2 text-sm font-medium text-gray-900">University</label>
                            <select 
                                id="university_id" 
                                name="university_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">All Universities</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}" {{ request('university_id') == $university->id ? 'selected' : '' }}>
                                        {{ $university->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select 
                                id="status" 
                                name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'university_id', 'status']))
                            <a 
                                href="{{ route('admin.university-users.index') }}" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>
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

            <!-- University Users Table -->
            @if($universityUsers->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">User</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">University</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Submissions</th>
                                    <th scope="col" class="px-6 py-3">Created</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($universityUsers as $user)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex items-center justify-center w-8 h-8 mr-3 bg-blue-600 text-white rounded-full text-xs font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-900">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            @if($user->university)
                                                <span class="text-gray-900 font-medium">{{ $user->university->name }}</span>
                                            @else
                                                <span class="text-gray-400 italic">Not assigned</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full 
                                                {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 
                                                   ($user->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">
                                            {{ $user->news_submissions_count ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.university-users.show', $user) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.university-users.edit', $user) }}" class="text-green-600 hover:text-green-900" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $universityUsers->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No university users found</h3>
                    <p class="text-sm text-gray-500 mb-6">
                        @if(request()->anyFilled(['search', 'university_id', 'status']))
                            Try adjusting your filters to see more results.
                        @else
                            Get started by creating your first university user.
                        @endif
                    </p>
                    <a href="{{ route('admin.university-users.create') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New User
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>


