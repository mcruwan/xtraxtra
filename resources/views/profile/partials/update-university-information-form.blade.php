<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            {{ __('University Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your university's information including name, domain, and contact details.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.university.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="university_name" :value="__('University Name')" />
            <x-text-input 
                id="university_name" 
                name="university_name" 
                type="text" 
                class="mt-1 block w-full" 
                :value="old('university_name', $user->university->name ?? '')" 
                required 
                autofocus 
                autocomplete="organization" />
            <x-input-error class="mt-2" :messages="$errors->updateUniversity->get('university_name')" />
        </div>

        <div>
            <x-input-label for="domain" :value="__('University Domain')" />
            <x-text-input 
                id="domain" 
                name="domain" 
                type="text" 
                class="mt-1 block w-full" 
                :value="old('domain', $user->university->domain ?? '')" 
                autocomplete="off"
                placeholder="e.g., university.edu" />
            <p class="mt-1 text-xs text-gray-500">Optional: Enter your university's domain (e.g., university.edu)</p>
            <x-input-error class="mt-2" :messages="$errors->updateUniversity->get('domain')" />
        </div>

        <div>
            <x-input-label for="contact_email" :value="__('Contact Email')" />
            <x-text-input 
                id="contact_email" 
                name="contact_email" 
                type="email" 
                class="mt-1 block w-full" 
                :value="old('contact_email', $user->university->contact_email ?? '')" 
                required 
                autocomplete="email" />
            <p class="mt-1 text-xs text-gray-500">Main contact email for university-related communications</p>
            <x-input-error class="mt-2" :messages="$errors->updateUniversity->get('contact_email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'university-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>


