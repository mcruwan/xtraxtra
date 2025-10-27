<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $university->name }}
            </h2>
            <a href="{{ route('admin.universities.edit', $university) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Edit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- University Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">University Details</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Name</div>
                            <div class="mt-1 text-sm text-gray-900">{{ $university->name }}</div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="mt-1">
                                <x-status-badge :status="$university->status" size="lg" />
                            </div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">Domain</div>
                            <div class="mt-1 text-sm text-gray-900">{{ $university->domain ?? 'N/A' }}</div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">Contact Email</div>
                            <div class="mt-1 text-sm text-gray-900">{{ $university->contact_email }}</div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">Registered</div>
                            <div class="mt-1 text-sm text-gray-900">{{ $university->created_at->format('M d, Y') }}</div>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-500">Total Users</div>
                            <div class="mt-1 text-sm text-gray-900">{{ $university->users->count() }}</div>
                        </div>
                    </div>

                    @if($university->status === 'pending')
                        <div class="mt-6 flex gap-3">
                            <form method="POST" action="{{ route('admin.universities.approve', $university) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Approve this university?')">
                                    Approve University
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.universities.reject', $university) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Reject and delete this university?')">
                                    Reject & Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Users List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">University Users</h3>
                    
                    @if($university->users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($university->users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-status-badge :status="$user->status" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

