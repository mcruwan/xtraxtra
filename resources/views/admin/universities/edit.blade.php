<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit University') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.universities.update', $university) }}">
                        @csrf
                        @method('PUT')

                        <!-- University Name -->
                        <div>
                            <x-input-label for="name" :value="__('University Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $university->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Domain -->
                        <div class="mt-4">
                            <x-input-label for="domain" :value="__('Domain (optional)')" />
                            <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain', $university->domain)" />
                            <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                        </div>

                        <!-- Contact Email -->
                        <div class="mt-4">
                            <x-input-label for="contact_email" :value="__('Contact Email')" />
                            <x-text-input id="contact_email" class="block mt-1 w-full" type="email" name="contact_email" :value="old('contact_email', $university->contact_email)" required />
                            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="pending" {{ old('status', $university->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ old('status', $university->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $university->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <form method="POST" action="{{ route('admin.universities.destroy', $university) }}" onsubmit="return confirm('Are you sure you want to delete this university? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                    Delete University
                                </button>
                            </form>

                            <div class="flex gap-4">
                                <a href="{{ route('admin.universities.index') }}" class="text-gray-600 hover:text-gray-900">
                                    Cancel
                                </a>
                                <x-primary-button>
                                    {{ __('Update University') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

