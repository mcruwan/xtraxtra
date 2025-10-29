<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ __('Universities') }}
            </h1>
            <a href="{{ route('admin.universities.create') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add University
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages - Flowbite Alerts -->
            @if(session('success'))
                <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-lg bg-green-50" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Success</span>
                    <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="alert-error" class="flex items-center p-4 mb-6 text-red-800 rounded-lg bg-red-50" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Error</span>
                    <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Filter Tabs - Flowbite Tabs -->
            <div class="mb-6">
                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                    <li class="me-2">
                        <a href="{{ route('admin.universities.index', ['status' => 'all']) }}" 
                           class="inline-block p-4 {{ $status === 'all' ? 'text-blue-600 border-b-2 border-blue-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" aria-current="{{ $status === 'all' ? 'page' : 'false' }}">
                            All
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="{{ route('admin.universities.index', ['status' => 'pending']) }}" 
                           class="inline-block p-4 {{ $status === 'pending' ? 'text-orange-600 border-b-2 border-orange-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" aria-current="{{ $status === 'pending' ? 'page' : 'false' }}">
                            Pending
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="{{ route('admin.universities.index', ['status' => 'active']) }}" 
                           class="inline-block p-4 {{ $status === 'active' ? 'text-green-600 border-b-2 border-green-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" aria-current="{{ $status === 'active' ? 'page' : 'false' }}">
                            Active
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="{{ route('admin.universities.index', ['status' => 'inactive']) }}" 
                           class="inline-block p-4 {{ $status === 'inactive' ? 'text-gray-600 border-b-2 border-gray-600 rounded-t-lg active' : 'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300' }}" aria-current="{{ $status === 'inactive' ? 'page' : 'false' }}">
                            Inactive
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Universities Table - Flowbite Standard Table -->
            @if($universities->count() > 0)
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    University
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Contact
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Users
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($universities as $university)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $university->name }}</div>
                                        @if($university->domain)
                                            <div class="text-sm text-gray-500">{{ $university->domain }}</div>
                                        @endif
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $university->contact_email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $university->users->count() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$university->status" />
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            @if($university->status === 'pending')
                                                <form method="POST" action="{{ route('admin.universities.approve', $university) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="font-medium text-green-600 hover:underline" onclick="return confirm('Approve this university?')">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.universities.reject', $university) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="font-medium text-red-600 hover:underline" onclick="return confirm('Reject and delete this university?')">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.universities.show', $university) }}" class="font-medium text-blue-600 hover:underline">View</a>
                                            <a href="{{ route('admin.universities.edit', $university) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination - Flowbite Pagination -->
                <div class="mt-6">
                    {{ $universities->links() }}
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-lg shadow p-12">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No universities found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new university.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.universities.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add University
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

