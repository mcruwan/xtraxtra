<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $university->name }}
            </h2>
            <a href="{{ route('admin.universities.edit', $university) }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- University Details - Flowbite Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 flex items-center text-gray-900">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        University Details
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-500">Name</label>
                            <div class="text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">{{ $university->name }}</div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-500">Status</label>
                            <div class="mt-1">
                                <x-status-badge :status="$university->status" size="lg" />
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-500">Domain</label>
                            <div class="text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">{{ $university->domain ?? 'N/A' }}</div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-500">Contact Email</label>
                            <div class="text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">{{ $university->contact_email }}</div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-500">Registered</label>
                            <div class="text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">{{ $university->created_at->format('M d, Y') }}</div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-500">Total Users</label>
                            <div class="text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">{{ $university->users->count() }}</div>
                        </div>
                    </div>

                    @if($university->status === 'pending')
                        <div class="mt-6 flex gap-3">
                            <form method="POST" action="{{ route('admin.universities.approve', $university) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:ring-green-300 transition-colors" onclick="return confirm('Approve this university?')">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve University
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.universities.reject', $university) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 transition-colors" onclick="return confirm('Reject and delete this university?')">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Reject & Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Users List - Flowbite Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 flex items-center text-gray-900">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        University Users
                    </h3>
                    
                    @if($university->users->count() > 0)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">Email</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                        <th scope="col" class="px-6 py-3">Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($university->users as $user)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $user->name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $user->email }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-status-badge :status="$user->status" />
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No users found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

