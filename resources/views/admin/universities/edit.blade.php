<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit University') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form id="update-university-form" method="POST" action="{{ route('admin.universities.update', $university) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- University Name -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                University Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $university->name) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 @enderror" 
                                   placeholder="Enter university name" 
                                   required 
                                   autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Domain -->
                        <div>
                            <label for="domain" class="block mb-2 text-sm font-medium text-gray-900">
                                University Domain (optional)
                            </label>
                            <input type="text" 
                                   id="domain" 
                                   name="domain" 
                                   value="{{ old('domain', $university->domain) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('domain') border-red-500 @enderror" 
                                   placeholder="e.g., university.edu">
                            @error('domain')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Email -->
                        <div>
                            <label for="contact_email" class="block mb-2 text-sm font-medium text-gray-900">
                                Contact Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="contact_email" 
                                   name="contact_email" 
                                   value="{{ old('contact_email', $university->contact_email) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('contact_email') border-red-500 @enderror" 
                                   placeholder="contact@university.edu" 
                                   required>
                            @error('contact_email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Logo Upload -->
                        <div>
                            <label for="logo" class="block mb-2 text-sm font-medium text-gray-900">
                                University Logo (optional)
                            </label>
                            @if($university->logo)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                    <img src="{{ asset('storage/' . $university->logo) }}" alt="{{ $university->name }}" class="h-20 w-48 object-cover rounded-lg border border-gray-200">
                                </div>
                            @endif
                            <input type="file" 
                                   id="logo" 
                                   name="logo" 
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('logo') border-red-500 @enderror" 
                                   accept="image/*">
                            <p class="mt-2 text-sm text-gray-500">Accepted formats: JPEG, PNG, JPG, GIF (Max 2MB)</p>
                            @error('logo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- WordPress User ID -->
                        <div>
                            <label for="wordpress_user_id" class="block mb-2 text-sm font-medium text-gray-900">
                                WordPress User ID (optional)
                            </label>
                            <input type="text" 
                                   id="wordpress_user_id" 
                                   name="wordpress_user_id" 
                                   value="{{ old('wordpress_user_id', $university->wordpress_user_id) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('wordpress_user_id') border-red-500 @enderror" 
                                   placeholder="e.g., admin, editor, or user ID">
                            <p class="mt-2 text-sm text-gray-500">The WordPress user account to associate articles pushed from this university.</p>
                            @error('wordpress_user_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('status') border-red-500 @enderror" 
                                    required>
                                <option value="pending" {{ old('status', $university->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ old('status', $university->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $university->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.universities.index') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update University
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>


