<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            {{ __('University Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your university's information including name, domain, contact details, and logo.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.university.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
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

        <!-- Logo Upload Section -->
        <div class="border-t pt-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">University Logo</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo Preview -->
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-3">Current Logo</p>
                    @if($user->university->logo)
                        <div class="relative w-full bg-gray-100 rounded-lg border border-gray-300 p-4 flex items-center justify-center" style="aspect-ratio: 4/3;">
                            <img src="{{ Storage::disk('public')->url($user->university->logo) }}" 
                                 alt="{{ $user->university->name }} logo" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                    @else
                        <div class="w-full bg-gray-100 rounded-lg border border-dashed border-gray-300 p-4 flex items-center justify-center" style="aspect-ratio: 4/3;">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500">No logo uploaded yet</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Upload Input -->
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-3">Upload New Logo</p>
                    <div class="relative">
                        <input 
                            type="file" 
                            id="logo" 
                            name="logo" 
                            accept="image/jpeg,image/png,image/gif,image/webp,image/jpg"
                            class="hidden"
                            onchange="previewLogo(this)" />
                        
                        <label for="logo" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-blue-300 rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100 transition-colors p-6">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <p class="text-sm text-blue-600 font-medium">
                                    Click to upload
                                </p>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF or WebP (Max 5MB)
                                </p>
                            </div>
                        </label>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Recommended size: 300x300px or larger. Supports JPEG, PNG, GIF, and WebP formats.
                    </p>
                    <x-input-error class="mt-2" :messages="$errors->updateUniversity->get('logo')" />
                    
                    <!-- Preview of newly selected file -->
                    <div id="logoPreview" class="mt-4 hidden">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview</p>
                        <div class="relative w-full bg-gray-100 rounded-lg border border-gray-300 p-4 flex items-center justify-center" style="aspect-ratio: 4/3;">
                            <img id="previewImage" src="" alt="Logo preview" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>
            </div>
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

    <script>
    function previewLogo(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewDiv = document.getElementById('logoPreview');
                const previewImage = document.getElementById('previewImage');
                previewImage.src = e.target.result;
                previewDiv.classList.remove('hidden');
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</section>



