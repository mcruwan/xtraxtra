<x-admin-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit Admin User</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Update admin user account information
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.admin-users.show', $adminUser) }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Details
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

            <!-- Form Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <form action="{{ route('admin.admin-users.update', $adminUser) }}" method="POST" class="space-y-6 p-6">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $adminUser->name) }}"
                            required
                            placeholder="e.g., John Doe"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 bg-red-50 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $adminUser->email) }}"
                            required
                            placeholder="e.g., admin@example.com"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') border-red-500 bg-red-50 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                            New Password <span class="text-gray-400 text-xs">(Leave blank to keep current password)</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            minlength="8"
                            placeholder="Minimum 8 characters"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password') border-red-500 bg-red-50 @enderror">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">Leave blank if you don't want to change the password. Minimum 8 characters if updating.</p>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">
                            Confirm New Password
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            minlength="8"
                            placeholder="Re-enter new password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password_confirmation') border-red-500 bg-red-50 @enderror">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-900">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="role" 
                            name="role" 
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('role') border-red-500 bg-red-50 @enderror">
                            <option value="">Select a role</option>
                            <option value="admin" {{ old('role', $adminUser->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ old('role', $adminUser->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="status" 
                            name="status" 
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('status') border-red-500 bg-red-50 @enderror">
                            <option value="">Select a status</option>
                            <option value="active" {{ old('status', $adminUser->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $adminUser->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-gray-50 border-t border-gray-200 -mx-6 -mb-6 mt-6 px-6 py-4 flex items-center justify-between gap-3">
                        <a href="{{ route('admin.admin-users.show', $adminUser) }}" class="text-gray-700 hover:text-gray-900 text-sm font-medium">Cancel</a>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Admin User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

