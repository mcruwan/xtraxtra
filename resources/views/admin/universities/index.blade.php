<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Universities') }}
            </h2>
            <a href="{{ route('admin.universities.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add University
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="mb-6 flex gap-2">
                <a href="{{ route('admin.universities.index', ['status' => 'all']) }}" 
                   class="px-4 py-2 rounded-md {{ $status === 'all' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    All
                </a>
                <a href="{{ route('admin.universities.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-md {{ $status === 'pending' ? 'bg-orange-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Pending
                </a>
                <a href="{{ route('admin.universities.index', ['status' => 'active']) }}" 
                   class="px-4 py-2 rounded-md {{ $status === 'active' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Active
                </a>
                <a href="{{ route('admin.universities.index', ['status' => 'inactive']) }}" 
                   class="px-4 py-2 rounded-md {{ $status === 'inactive' ? 'bg-gray-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Inactive
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <x-alert type="success" class="mb-6" :dismissible="true">
                    {{ session('success') }}
                </x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error" class="mb-6" :dismissible="true">
                    {{ session('error') }}
                </x-alert>
            @endif

            <!-- Universities Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($universities->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">University</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($universities as $university)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $university->name }}</div>
                                                @if($university->domain)
                                                    <div class="text-sm text-gray-500">{{ $university->domain }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $university->contact_email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $university->users->count() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-status-badge :status="$university->status" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex gap-2">
                                                    @if($university->status === 'pending')
                                                        <form method="POST" action="{{ route('admin.universities.approve', $university) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Approve this university?')">
                                                                Approve
                                                            </button>
                                                        </form>
                                                        <span class="text-gray-300">|</span>
                                                        <form method="POST" action="{{ route('admin.universities.reject', $university) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Reject and delete this university?')">
                                                                Reject
                                                            </button>
                                                        </form>
                                                        <span class="text-gray-300">|</span>
                                                    @endif
                                                    <a href="{{ route('admin.universities.show', $university) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                    <span class="text-gray-300">|</span>
                                                    <a href="{{ route('admin.universities.edit', $university) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $universities->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No universities found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

