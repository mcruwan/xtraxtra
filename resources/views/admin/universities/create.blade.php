<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create University') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.universities.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- University Name -->
                        <div>
                            <x-input-label for="name" :value="__('University Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Domain -->
                        <div class="mt-4">
                            <x-input-label for="domain" :value="__('Domain (optional)')" />
                            <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain')" />
                            <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                        </div>

                        <!-- Contact Email -->
                        <div class="mt-4">
                            <x-input-label for="contact_email" :value="__('Contact Email')" />
                            <x-text-input id="contact_email" class="block mt-1 w-full" type="email" name="contact_email" :value="old('contact_email')" required />
                            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                        </div>

                        <!-- Logo Upload -->
                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('University Logo (optional)')" />
                            <input type="file" id="logo" name="logo" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" accept="image/*" />
                            <p class="mt-2 text-sm text-gray-500">Accepted formats: JPEG, PNG, JPG, GIF (Max 2MB)</p>
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>

                        <!-- WordPress User ID -->
                        <div class="mt-4">
                            <x-input-label for="wordpress_user_id" :value="__('WordPress User ID (optional)')" />
                            <x-text-input id="wordpress_user_id" class="block mt-1 w-full" type="text" name="wordpress_user_id" :value="old('wordpress_user_id')" placeholder="e.g., admin, editor, or user ID" />
                            <p class="mt-2 text-sm text-gray-500">The WordPress user account to associate articles pushed from this university.</p>
                            <x-input-error :messages="$errors->get('wordpress_user_id')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900 bg-white" required>
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }} class="text-gray-900">Pending</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }} class="text-gray-900">Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }} class="text-gray-900">Inactive</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('admin.universities.index') }}" class="text-gray-600 hover:text-gray-900">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Create University') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>


