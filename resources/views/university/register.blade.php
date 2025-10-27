<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Register Your University</h2>
        <p class="text-sm text-gray-600 mt-2">Submit your university for approval to start publishing news</p>
    </div>

    <form method="POST" action="{{ route('university.register.store') }}">
        @csrf

        <!-- University Information -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 pb-2 border-b">University Information</h3>
            
            <!-- University Name -->
            <div class="mt-4">
                <x-input-label for="university_name" :value="__('University Name')" />
                <x-text-input id="university_name" class="block mt-1 w-full" type="text" name="university_name" :value="old('university_name')" required autofocus />
                <x-input-error :messages="$errors->get('university_name')" class="mt-2" />
            </div>

            <!-- Domain -->
            <div class="mt-4">
                <x-input-label for="domain" :value="__('University Domain (optional)')" />
                <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain')" placeholder="e.g., university.edu" />
                <x-input-error :messages="$errors->get('domain')" class="mt-2" />
            </div>

            <!-- Contact Email -->
            <div class="mt-4">
                <x-input-label for="contact_email" :value="__('Contact Email')" />
                <x-text-input id="contact_email" class="block mt-1 w-full" type="email" name="contact_email" :value="old('contact_email')" required />
                <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
            </div>
        </div>

        <!-- Administrator Account -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 pb-2 border-b">Administrator Account</h3>
            
            <!-- Admin Name -->
            <div class="mt-4">
                <x-input-label for="admin_name" :value="__('Full Name')" />
                <x-text-input id="admin_name" class="block mt-1 w-full" type="text" name="admin_name" :value="old('admin_name')" required />
                <x-input-error :messages="$errors->get('admin_name')" class="mt-2" />
            </div>

            <!-- Admin Email -->
            <div class="mt-4">
                <x-input-label for="admin_email" :value="__('Email Address')" />
                <x-text-input id="admin_email" class="block mt-1 w-full" type="email" name="admin_email" :value="old('admin_email')" required />
                <x-input-error :messages="$errors->get('admin_email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="admin_password" :value="__('Password')" />
                <x-text-input id="admin_password" class="block mt-1 w-full" type="password" name="admin_password" required />
                <x-input-error :messages="$errors->get('admin_password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="admin_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="admin_password_confirmation" class="block mt-1 w-full" type="password" name="admin_password_confirmation" required />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already have an account?') }}
            </a>

            <x-primary-button>
                {{ __('Submit Registration') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

