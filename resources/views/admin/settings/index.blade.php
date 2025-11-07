<x-admin-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Platform Settings</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Configure your platform settings, branding, and preferences
                        </p>
                    </div>
                </div>
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

            @if(session('info'))
                <x-alert type="info" class="mb-6" :dismissible="true">
                    {{ session('info') }}
                </x-alert>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium mb-2">Please correct the following errors:</h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Settings Tabs -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <button 
                            onclick="switchTab('general')" 
                            id="tab-general"
                            class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-blue-600 text-blue-600 active"
                            data-tab="general">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            General
                        </button>
                        <button 
                            onclick="switchTab('email-api')" 
                            id="tab-email-api"
                            class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            data-tab="email-api">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                            Email & API
                        </button>
                        <button 
                            onclick="switchTab('email-templates')" 
                            id="tab-email-templates"
                            class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            data-tab="email-templates">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Email Templates
                        </button>
                        <!-- Future tabs can be added here -->
                    </nav>
                </div>
            </div>

            <!-- Settings Sections -->
            <div class="space-y-6">
                <!-- General Tab Content -->
                <div id="tab-content-general" class="tab-content">
                    <!-- Platform Logo Section -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                            <h2 class="text-lg font-semibold text-gray-900">Platform Logo</h2>
                            <p class="mt-1 text-sm text-gray-600">Upload your platform logos to be displayed in the header. Use dark logo for light backgrounds and light logo for dark backgrounds.</p>
                        </div>
                        <div class="p-6 space-y-8">
                            <!-- Dark Logo Section (for light backgrounds) -->
                            <div>
                                <h3 class="text-md font-semibold text-gray-900 mb-4">Dark Logo (for light backgrounds)</h3>
                                
                                @php
                                    $currentDarkLogo = $settings['platform_logo_dark'] ?? null;
                                @endphp

                                @if($currentDarkLogo && $currentDarkLogo->value)
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-900 mb-3">Current Dark Logo</label>
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 bg-gray-100 rounded-lg p-4 border border-gray-200">
                                                <img src="{{ Storage::url($currentDarkLogo->value) }}" alt="Dark Platform Logo" class="h-24 w-auto object-contain">
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3">
                                                    <form action="{{ route('admin.settings.logo.remove', ['type' => 'dark']) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove the dark logo?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Remove Dark Logo
                                                        </button>
                                                    </form>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-2">Upload a new dark logo to replace the current one</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-6">
                                        <div class="flex items-center justify-center w-full h-32 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg">
                                            <div class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-600 font-medium">No dark logo uploaded yet</p>
                                                <p class="text-xs text-gray-500">Upload your dark platform logo below</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Dark Logo Upload Form -->
                                <form action="{{ route('admin.settings.logo.update', ['type' => 'dark']) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label for="platform_logo_dark" class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ ($currentDarkLogo && $currentDarkLogo->value) ? 'Upload New Dark Logo' : 'Upload Dark Logo' }}
                                                @if($errors->has('platform_logo_dark'))
                                                    <span class="text-red-600 font-normal">*</span>
                                                @endif
                                            </label>
                                            <input 
                                                type="file" 
                                                id="platform_logo_dark" 
                                                name="platform_logo_dark" 
                                                accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml"
                                                class="block w-full text-sm text-gray-900 border {{ $errors->has('platform_logo_dark') ? 'border-red-500' : 'border-gray-300' }} rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2.5 file:px-4 file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            @error('platform_logo_dark')
                                                <x-input-error :messages="$errors->get('platform_logo_dark')" class="mt-2" />
                                            @enderror
                                            <p class="mt-2 text-xs text-gray-500">Supported formats: JPG, JPEG, PNG, GIF, SVG. Maximum size: 2MB</p>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Dark Logo
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-200"></div>

                            <!-- Light Logo Section (for dark backgrounds) -->
                            <div>
                                <h3 class="text-md font-semibold text-gray-900 mb-4">Light Logo (for dark backgrounds)</h3>
                                
                                @php
                                    $currentLightLogo = $settings['platform_logo_light'] ?? null;
                                @endphp

                                @if($currentLightLogo && $currentLightLogo->value)
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-900 mb-3">Current Light Logo</label>
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 bg-gray-900 rounded-lg p-4 border border-gray-700">
                                                <img src="{{ Storage::url($currentLightLogo->value) }}" alt="Light Platform Logo" class="h-24 w-auto object-contain">
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3">
                                                    <form action="{{ route('admin.settings.logo.remove', ['type' => 'light']) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove the light logo?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Remove Light Logo
                                                        </button>
                                                    </form>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-2">Upload a new light logo to replace the current one</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-6">
                                        <div class="flex items-center justify-center w-full h-32 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg">
                                            <div class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-600 font-medium">No light logo uploaded yet</p>
                                                <p class="text-xs text-gray-500">Upload your light platform logo below</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Light Logo Upload Form -->
                                <form action="{{ route('admin.settings.logo.update', ['type' => 'light']) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label for="platform_logo_light" class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ ($currentLightLogo && $currentLightLogo->value) ? 'Upload New Light Logo' : 'Upload Light Logo' }}
                                                @if($errors->has('platform_logo_light'))
                                                    <span class="text-red-600 font-normal">*</span>
                                                @endif
                                            </label>
                                            <input 
                                                type="file" 
                                                id="platform_logo_light" 
                                                name="platform_logo_light" 
                                                accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml"
                                                class="block w-full text-sm text-gray-900 border {{ $errors->has('platform_logo_light') ? 'border-red-500' : 'border-gray-300' }} rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2.5 file:px-4 file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            @error('platform_logo_light')
                                                <x-input-error :messages="$errors->get('platform_logo_light')" class="mt-2" />
                                            @enderror
                                            <p class="mt-2 text-xs text-gray-500">Supported formats: JPG, JPEG, PNG, GIF, SVG. Maximum size: 2MB</p>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Upload Light Logo
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- General Settings Section -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                            <h2 class="text-lg font-semibold text-gray-900">General Settings</h2>
                            <p class="mt-1 text-sm text-gray-600">Configure basic platform information</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="space-y-6">
                                    <!-- Platform Name -->
                                    <div>
                                        <label for="platform_name" class="block text-sm font-medium text-gray-900 mb-2">Platform Name</label>
                                        <input 
                                            type="text" 
                                            id="platform_name" 
                                            name="platform_name" 
                                            value="{{ old('platform_name', isset($settings['platform_name']) ? $settings['platform_name']->value : '') }}"
                                            placeholder="e.g., AppliedHE Xtra! Xtra!"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <p class="mt-2 text-xs text-gray-500">This name will be displayed in the header and page titles</p>
                                    </div>

                                    <!-- Platform Tagline -->
                                    <div>
                                        <label for="platform_tagline" class="block text-sm font-medium text-gray-900 mb-2">Platform Tagline</label>
                                        <input 
                                            type="text" 
                                            id="platform_tagline" 
                                            name="platform_tagline" 
                                            value="{{ old('platform_tagline', isset($settings['platform_tagline']) ? $settings['platform_tagline']->value : '') }}"
                                            placeholder="e.g., Your University News Hub"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <p class="mt-2 text-xs text-gray-500">A short description of your platform</p>
                                    </div>

                                    <!-- Contact Email -->
                                    <div>
                                        <label for="contact_email" class="block text-sm font-medium text-gray-900 mb-2">Contact Email</label>
                                        <input 
                                            type="email" 
                                            id="contact_email" 
                                            name="contact_email" 
                                            value="{{ old('contact_email', isset($settings['contact_email']) ? $settings['contact_email']->value : '') }}"
                                            placeholder="e.g., contact@example.com"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <p class="mt-2 text-xs text-gray-500">Primary contact email for support and inquiries</p>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex items-center space-x-3 pt-4">
                                        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Save Settings
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Email & API Tab Content -->
                <div id="tab-content-email-api" class="tab-content hidden">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                            <h2 class="text-lg font-semibold text-gray-900">Email & API Settings</h2>
                            <p class="mt-1 text-sm text-gray-600">Configure email service providers and API credentials</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.settings.update-email-api') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="space-y-6">
                                    <!-- Brevo API Section -->
                                    <div class="border-b border-gray-200 pb-6">
                                        <h3 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                            </svg>
                                            Brevo API Configuration
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-4">Configure Brevo API credentials for email functionality</p>
                                        
                                        <div class="space-y-4">
                                            <!-- Brevo API Key -->
                                            <div>
                                                <label for="bravo_api_key" class="block text-sm font-medium text-gray-900 mb-2">
                                                    Brevo API Key
                                                    @if($errors->has('bravo_api_key'))
                                                        <span class="text-red-600 font-normal">*</span>
                                                    @endif
                                                </label>
                                                <input 
                                                    type="text" 
                                                    id="bravo_api_key" 
                                                    name="bravo_api_key" 
                                                    value="{{ old('bravo_api_key', isset($settings['bravo_api_key']) ? $settings['bravo_api_key']->value : '') }}"
                                                    placeholder="Enter your Brevo API key"
                                                    class="bg-gray-50 border {{ $errors->has('bravo_api_key') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-mono">
                                                @error('bravo_api_key')
                                                    <x-input-error :messages="$errors->get('bravo_api_key')" class="mt-2" />
                                                @enderror
                                                <div class="mt-2 flex items-center space-x-3">
                                                    <p class="text-xs text-gray-500 flex-1">Your Brevo API key for email service integration</p>
                                                    <button 
                                                        type="button" 
                                                        id="test-api-key-btn"
                                                        onclick="testBrevoApiKey()"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:ring-2 focus:outline-none focus:ring-blue-300 transition-colors">
                                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Test API Key
                                                    </button>
                                                </div>
                                                <!-- Test Result Display -->
                                                <div id="api-test-result" class="mt-2 hidden"></div>
                                            </div>

                                            <!-- Brevo API Secret -->
                                            <div>
                                                <label for="bravo_api_secret" class="block text-sm font-medium text-gray-900 mb-2">
                                                    Brevo API Secret
                                                    @if($errors->has('bravo_api_secret'))
                                                        <span class="text-red-600 font-normal">*</span>
                                                    @endif
                                                </label>
                                                <input 
                                                    type="password" 
                                                    id="bravo_api_secret" 
                                                    name="bravo_api_secret" 
                                                    value="{{ old('bravo_api_secret', isset($settings['bravo_api_secret']) ? $settings['bravo_api_secret']->value : '') }}"
                                                    placeholder="Enter your Brevo API secret"
                                                    class="bg-gray-50 border {{ $errors->has('bravo_api_secret') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-mono">
                                                @error('bravo_api_secret')
                                                    <x-input-error :messages="$errors->get('bravo_api_secret')" class="mt-2" />
                                                @enderror
                                                <p class="mt-2 text-xs text-gray-500">Your Brevo API secret key (hidden for security)</p>
                                                <button type="button" onclick="togglePasswordVisibility('bravo_api_secret')" class="mt-2 text-xs text-blue-600 hover:text-blue-800">
                                                    Show/Hide Secret
                                                </button>
                                                <p class="mt-1 text-xs text-gray-500 italic">Leave blank to keep the current secret unchanged</p>
                                            </div>

                                            <!-- Brevo API Base URL (Optional) -->
                                            <div>
                                                <label for="bravo_api_base_url" class="block text-sm font-medium text-gray-900 mb-2">
                                                    Brevo API Base URL
                                                    <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                                                </label>
                                                <input 
                                                    type="url" 
                                                    id="bravo_api_base_url" 
                                                    name="bravo_api_base_url" 
                                                    value="{{ old('bravo_api_base_url', isset($settings['bravo_api_base_url']) ? $settings['bravo_api_base_url']->value : '') }}"
                                                    placeholder="https://api.brevo.com"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                @error('bravo_api_base_url')
                                                    <x-input-error :messages="$errors->get('bravo_api_base_url')" class="mt-2" />
                                                @enderror
                                                <p class="mt-2 text-xs text-gray-500">Base URL for Brevo API endpoints (defaults to official endpoint if not provided)</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Info Box -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <h4 class="text-sm font-medium text-blue-900 mb-1">API Credentials Security</h4>
                                                <p class="text-sm text-blue-700">Your API credentials are stored securely and encrypted. Never share these credentials publicly. These settings will be used for email functionality throughout the platform.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex items-center space-x-3 pt-4">
                                        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Save Email & API Settings
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Email Templates Tab Content -->
                <div id="tab-content-email-templates" class="tab-content hidden">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Email Templates</h2>
                                    <p class="mt-1 text-sm text-gray-600">Manage email templates for different notifications and communications</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <!-- Templates Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <!-- Article Approval Template Card -->
                                <div class="border border-gray-200 rounded-lg hover:border-blue-500 transition-colors cursor-pointer" onclick="openTemplateEditor('approval')">
                                    <div class="p-5">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100 text-green-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-lg font-medium text-gray-900">Article Approval</h3>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ isset($settings['enable_approval_notifications']) && $settings['enable_approval_notifications']->value == '1' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ isset($settings['enable_approval_notifications']) && $settings['enable_approval_notifications']->value == '1' ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    Sent to universities when their news articles are approved by administrators
                                                </p>
                                                <div class="mt-4 flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Last modified: {{ isset($settings['approval_email_template']) ? $settings['approval_email_template']->updated_at->format('M d, Y') : 'Never' }}
                                                </div>
                                                <div class="mt-3 flex items-center space-x-2">
                                                    <button 
                                                        type="button"
                                                        onclick="event.stopPropagation(); openTemplateEditor('approval')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit Template
                                                    </button>
                                                    <button 
                                                        type="button"
                                                        onclick="event.stopPropagation(); sendTestEmail('approval')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                        </svg>
                                                        Send Test
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Article Rejection Template Card -->
                                <div class="border border-gray-200 rounded-lg hover:border-blue-500 transition-colors cursor-pointer" onclick="openTemplateEditor('rejection')">
                                    <div class="p-5">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-red-100 text-red-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-lg font-medium text-gray-900">Article Rejection</h3>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ isset($settings['enable_rejection_notifications']) && $settings['enable_rejection_notifications']->value == '1' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ isset($settings['enable_rejection_notifications']) && $settings['enable_rejection_notifications']->value == '1' ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    Sent to universities when their news articles are rejected with feedback
                                                </p>
                                                <div class="mt-4 flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Last modified: {{ isset($settings['rejection_email_template']) ? $settings['rejection_email_template']->updated_at->format('M d, Y') : 'Never' }}
                                                </div>
                                                <div class="mt-3 flex items-center space-x-2">
                                                    <button 
                                                        type="button"
                                                        onclick="event.stopPropagation(); openTemplateEditor('rejection')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit Template
                                                    </button>
                                                    <button 
                                                        type="button"
                                                        onclick="event.stopPropagation(); sendTestEmail('rejection')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                        </svg>
                                                        Send Test
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Registration Received Template Card -->
                                <div class="border border-gray-200 rounded-lg hover:border-blue-500 transition-colors cursor-pointer" onclick="openTemplateEditor('registration_received')">
                                    <div class="p-5">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-blue-100 text-blue-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-lg font-medium text-gray-900">Registration Received</h3>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ isset($settings['enable_registration_received_notifications']) && $settings['enable_registration_received_notifications']->value == '1' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ isset($settings['enable_registration_received_notifications']) && $settings['enable_registration_received_notifications']->value == '1' ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    Sent to universities immediately when they register (pending approval)
                                                </p>
                                                <div class="mt-4 flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Last modified: {{ isset($settings['registration_received_email_template']) ? $settings['registration_received_email_template']->updated_at->format('M d, Y') : 'Never' }}
                                                </div>
                                                <div class="mt-3 flex items-center space-x-2">
                                                    <button 
                                                        type="button"
                                                        onclick="event.stopPropagation(); openTemplateEditor('registration_received')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit Template
                                                    </button>
                                                    <button 
                                                        type="button"
                                                        onclick="event.stopPropagation(); sendTestEmail('registration_received')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                        </svg>
                                                        Send Test
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Registration Approved Template Card -->
                                <div class="border border-gray-200 rounded-lg hover:border-blue-500 transition-colors cursor-pointer" onclick="openTemplateEditor('registration_approved')">
                                    <div class="p-5">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100 text-green-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-lg font-medium text-gray-900">Registration Approved</h3>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ isset($settings['enable_registration_approved_notifications']) && $settings['enable_registration_approved_notifications']->value == '1' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ isset($settings['enable_registration_approved_notifications']) && $settings['enable_registration_approved_notifications']->value == '1' ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    Sent to universities when their registration is approved by admin
                                                </p>
                                                <div class="mt-4 flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Last modified: {{ isset($settings['registration_approved_email_template']) ? $settings['registration_approved_email_template']->updated_at->format('M d, Y') : 'Never' }}
                                                </div>
                                                <div class="mt-3 flex items-center space-x-2">
                                                    <button 
                                                        type="button"
                                                        onclick="event.stopPropagation(); openTemplateEditor('registration_approved')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit Template
                                                    </button>
                                                    <button 
                                                        type="button"
                                                        onclick="event.stopPropagation(); sendTestEmail('registration_approved')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                        </svg>
                                                        Send Test
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Placeholder for Future Templates -->
                                <div class="border-2 border-dashed border-gray-300 rounded-lg hover:border-gray-400 transition-colors">
                                    <div class="p-5 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">More templates coming soon</h3>
                                        <p class="mt-1 text-sm text-gray-500">Additional email templates will be added here</p>
                                    </div>
                                </div>

                            </div>

                            <!-- Info Box -->
                            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-blue-900 mb-1">About Email Templates</h4>
                                        <p class="text-sm text-blue-700">
                                            Click on any template card to edit its content, subject line, and settings. Each template supports dynamic variables that are automatically replaced with actual data when emails are sent. Make sure to test your changes before activating a template.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Future tabs content can be added here -->
            </div>
        </div>
    </div>

    <!-- Test Email Modal -->
    <div id="testEmailModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50" onclick="closeTestEmailModal(event)">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
                <!-- Modal Header -->
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Send Test Email</h3>
                    <button type="button" onclick="closeTestEmailModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">
                        Enter your email address to receive a test email with sample data. This will help you preview how the template looks.
                    </p>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="test_recipient_email" class="block text-sm font-medium text-gray-900 mb-2">
                                Recipient Email Address
                            </label>
                            <input 
                                type="email" 
                                id="test_recipient_email" 
                                value="{{ auth()->user()->email }}"
                                placeholder="your@email.com"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <p class="mt-2 text-xs text-gray-500">The test email will be sent with dummy article data for preview purposes.</p>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-xs text-yellow-700">Make sure your Brevo API is configured in Email & API settings before sending test emails.</p>
                            </div>
                        </div>
                        
                        <!-- Result Message -->
                        <div id="testEmailResult" class="hidden"></div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeTestEmailModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="button" id="sendTestBtn" onclick="sendTestEmailNow()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                        <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send Test Email
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Template Editor Modal -->
    <div id="templateEditorModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50" onclick="closeTemplateEditor(event)">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
                <!-- Modal Header -->
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Edit Email Template</h3>
                    <button type="button" onclick="closeTemplateEditor()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]" id="modalBody">
                    <!-- Content will be loaded dynamically -->
                </div>

                <!-- Modal Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeTemplateEditor()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="button" onclick="saveTemplate()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                        Save Template
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation Script -->
    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-blue-600', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab content
            const selectedContent = document.getElementById('tab-content-' + tabName);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }

            // Add active state to selected tab
            const selectedTab = document.getElementById('tab-' + tabName);
            if (selectedTab) {
                selectedTab.classList.remove('border-transparent', 'text-gray-500');
                selectedTab.classList.add('border-blue-600', 'text-blue-600', 'active');
            }

            // Store active tab in URL hash for bookmarking
            if (history.replaceState) {
                history.replaceState(null, null, '#' + tabName);
            }
        }

        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }

        function testBrevoApiKey() {
            console.log('testBrevoApiKey function called');
            const apiKeyInput = document.getElementById('bravo_api_key');
            const apiSecretInput = document.getElementById('bravo_api_secret');
            const baseUrlInput = document.getElementById('bravo_api_base_url');
            const testBtn = document.getElementById('test-api-key-btn');
            const resultDiv = document.getElementById('api-test-result');
            
            if (!apiKeyInput || !testBtn || !resultDiv) {
                console.error('Required elements not found:', {
                    apiKeyInput: !!apiKeyInput,
                    testBtn: !!testBtn,
                    resultDiv: !!resultDiv
                });
                alert('Error: Required elements not found. Please refresh the page.');
                return;
            }
            
            const apiKey = apiKeyInput.value.trim();
            const apiSecret = apiSecretInput.value.trim();
            const baseUrl = baseUrlInput.value.trim();
            
            if (!apiKey) {
                showTestResult('error', 'Please enter an API key first.');
                return;
            }
            
            console.log('Starting API key test...');
            
            // Disable button and show loading state
            testBtn.disabled = true;
            testBtn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Testing...';
            
            // Clear previous result
            resultDiv.classList.add('hidden');
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value;
            
            console.log('CSRF Token:', csrfToken ? 'Found' : 'NOT FOUND');
            console.log('API Key:', apiKey ? 'Provided' : 'Missing');
            console.log('Fetch URL:', '{{ route("admin.settings.test-brevo-api") }}');
            
            // Make AJAX request
            console.log('Sending fetch request...');
            fetch('{{ route("admin.settings.test-brevo-api") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    api_key: apiKey,
                    api_secret: apiSecret || null,
                    base_url: baseUrl || null,
                }),
            })
            .then(async response => {
                console.log('Fetch response received:', response.status, response.statusText);
                // Parse JSON response
                let data;
                try {
                    const responseText = await response.text();
                    console.log('Response text:', responseText);
                    data = JSON.parse(responseText);
                    console.log('Parsed data:', data);
                } catch (e) {
                    // If response is not JSON, create error object
                    console.error('Failed to parse JSON response:', e);
                    data = {
                        success: false,
                        message: `HTTP ${response.status}: ${response.statusText || 'Unknown error'}`
                    };
                }
                
                // Check if response was successful (200 OK)
                if (!response.ok) {
                    // Handle HTTP errors (network errors, server errors, etc.)
                    const errorMessage = data.message || `API key test failed with status ${response.status}`;
                    console.log('Response not OK, throwing error:', errorMessage);
                    throw new Error(errorMessage);
                }
                
                console.log('Returning data:', data);
                return data;
            })
            .then(data => {
                console.log('Processing response data:', data);
                // Re-enable button
                testBtn.disabled = false;
                testBtn.innerHTML = '<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Test API Key';
                
                if (data.success) {
                    console.log('Success case, showing success message');
                    let accountInfo = '';
                    if (data.account) {
                        accountInfo = '<div class="mt-3 pt-3 border-t border-green-200 text-xs text-gray-700 space-y-1">';
                        accountInfo += '<p class="font-semibold text-gray-900 mb-2">Account Information:</p>';
                        if (data.account.email && data.account.email !== 'N/A') {
                            accountInfo += `<p><strong>Email:</strong> ${data.account.email}</p>`;
                        }
                        if (data.account.companyName && data.account.companyName !== 'N/A') {
                            accountInfo += `<p><strong>Company:</strong> ${data.account.companyName}</p>`;
                        }
                        if (data.account.firstName && data.account.firstName !== 'N/A') {
                            accountInfo += `<p><strong>Name:</strong> ${data.account.firstName} ${data.account.lastName || ''}</p>`;
                        }
                        accountInfo += '</div>';
                    }
                    
                    // Add test email information if available
                    let emailInfo = '';
                    if (data.test_email) {
                        emailInfo = '<div class="mt-3 pt-3 border-t border-green-200">';
                        if (data.email_sent) {
                            emailInfo += '<p class="text-xs text-green-700 flex items-center"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg><strong>Test email sent successfully to:</strong> ' + data.test_email + '</p>';
                        } else {
                            emailInfo += '<p class="text-xs text-yellow-700 flex items-center"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>Test email could not be sent to: ' + data.test_email + '</p>';
                        }
                        emailInfo += '</div>';
                    }
                    
                    showTestResult('success', data.message + accountInfo + emailInfo);
                } else {
                    console.log('Error case, showing error message:', data.message);
                    console.log('About to call showTestResult with error type');
                    try {
                        showTestResult('error', data.message || 'API key test failed.');
                        console.log('showTestResult call completed');
                    } catch (e) {
                        console.error('Error in showTestResult:', e);
                        alert('Error displaying result: ' + e.message);
                    }
                }
            })
            .catch(error => {
                console.error('Catch block triggered:', error);
                console.error('Error stack:', error.stack);
                // Re-enable button
                testBtn.disabled = false;
                testBtn.innerHTML = '<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Test API Key';
                
                // Extract error message
                let errorMessage = 'An error occurred while testing the API key. Please try again.';
                if (error.message) {
                    errorMessage = error.message;
                } else if (error.toString) {
                    errorMessage = error.toString();
                }
                
                console.log('Formatted error message:', errorMessage);
                
                // Format the error message nicely
                let formattedMessage = errorMessage;
                if (errorMessage.includes('IP address')) {
                    formattedMessage = '<div class="space-y-2">' +
                        '<p class="font-semibold">IP Address Not Authorized</p>' +
                        '<p>' + errorMessage + '</p>' +
                        '<p class="text-xs mt-2">Please add your IP address to the authorized IPs list in your Brevo account settings.</p>' +
                        '</div>';
                }
                
                console.log('Calling showTestResult with error');
                try {
                    showTestResult('error', formattedMessage);
                    console.log('showTestResult call completed in catch block');
                } catch (e) {
                    console.error('Error in showTestResult (catch block):', e);
                    alert('Error displaying result: ' + e.message);
                }
            });
        }
        
        function showTestResult(type, message) {
            console.log('=== showTestResult START ===');
            console.log('Type:', type);
            console.log('Message:', message);
            
            const resultDiv = document.getElementById('api-test-result');
            console.log('Result div element:', resultDiv);
            
            if (!resultDiv) {
                console.error('Result div not found!');
                alert('Error: Result display area not found. Please refresh the page.');
                return;
            }
            
            console.log('Result div found!');
            console.log('Current classes:', resultDiv.className);
            console.log('Current display:', window.getComputedStyle(resultDiv).display);
            console.log('Current visibility:', window.getComputedStyle(resultDiv).visibility);
            
            // Force remove hidden class
            resultDiv.classList.remove('hidden');
            resultDiv.removeAttribute('hidden');
            
            // Force visibility with inline styles
            resultDiv.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; height: auto !important;';
            
            console.log('After modification:');
            console.log('- Classes:', resultDiv.className);
            console.log('- Display:', resultDiv.style.display);
            console.log('- Computed display:', window.getComputedStyle(resultDiv).display);
            
            // Set content based on type
            if (type === 'success') {
                resultDiv.className = 'mt-3 p-4 bg-green-50 border-2 border-green-300 rounded-lg shadow-sm';
                resultDiv.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-green-900 mb-2">✓ Success!</h4>
                            <div class="text-sm text-green-800">${message}</div>
                        </div>
                    </div>
                `;
            } else {
                resultDiv.className = 'mt-3 p-4 bg-red-50 border-2 border-red-300 rounded-lg shadow-sm';
                resultDiv.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-red-900 mb-2">✗ Test Failed</h4>
                            <div class="text-sm text-red-800">${message}</div>
                        </div>
                    </div>
                `;
            }
            
            console.log('InnerHTML set, length:', resultDiv.innerHTML.length);
            console.log('Final computed display:', window.getComputedStyle(resultDiv).display);
            console.log('=== showTestResult END ===');
            
            // Scroll to result
            setTimeout(() => {
                resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        }

        // Email Template Modal Functions
        function openTemplateEditor(templateType) {
            const modal = document.getElementById('templateEditorModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');
            
            // Set modal title
            const titles = {
                'approval': 'Edit Article Approval Email Template',
                'rejection': 'Edit Article Rejection Email Template',
                'registration_received': 'Edit Registration Received Email Template',
                'registration_approved': 'Edit Registration Approved Email Template'
            };
            modalTitle.textContent = titles[templateType] || 'Edit Email Template';
            
            // Load template content based on type
            if (templateType === 'approval') {
                modalBody.innerHTML = `
                    <form id="templateForm" method="POST" action="{{ route('admin.settings.update-email-templates') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="template_type" value="approval">
                        
                        <div class="space-y-6">
                            <!-- Enable/Disable Toggle -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Template Status</h4>
                                    <p class="text-sm text-gray-500 mt-1">Enable or disable this email notification</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_approval_notifications" value="1" class="sr-only peer" ${`{{ isset($settings['enable_approval_notifications']) && $settings['enable_approval_notifications']->value == '1' ? 'checked' : '' }}`}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Active</span>
                                </label>
                            </div>
                            
                            <!-- Email Subject -->
                            <div>
                                <label for="modal_approval_email_subject" class="block text-sm font-medium text-gray-900 mb-2">
                                    Email Subject Line
                                </label>
                                <input 
                                    type="text" 
                                    id="modal_approval_email_subject" 
                                    name="approval_email_subject" 
                                    value="{{ old('approval_email_subject', isset($settings['approval_email_subject']) ? $settings['approval_email_subject']->value : 'News Submission Approved - {article_title}') }}"
                                    placeholder="News Submission Approved - {article_title}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <p class="mt-2 text-xs text-gray-500">Available variables: {user_name}, {article_title}, {status}, {platform_name}</p>
                            </div>
                            
                            <!-- Email Template -->
                            <div>
                                <label for="modal_approval_email_template" class="block text-sm font-medium text-gray-900 mb-2">
                                    Email HTML Template
                                </label>
                                <textarea 
                                    id="modal_approval_email_template" 
                                    name="approval_email_template" 
                                    rows="15"
                                    placeholder="Enter your HTML email template here..."
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-mono text-xs">{{ old('approval_email_template', isset($settings['approval_email_template']) ? $settings['approval_email_template']->value : '') }}</textarea>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs text-gray-500"><strong>Available variables:</strong></p>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{user_name}</code> - Recipient name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{user_email}</code> - Recipient email</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{article_title}</code> - Article title</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{article_excerpt}</code> - Article excerpt</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{status}</code> - Article status</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{approved_at}</code> - Approval date</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{scheduled_at}</code> - Scheduled date</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{dashboard_url}</code> - Dashboard link</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{university_name}</code> - University name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{approver_name}</code> - Approver name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{platform_name}</code> - Platform name</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                `;
            } else if (templateType === 'rejection') {
                modalBody.innerHTML = `
                    <form id="templateForm" method="POST" action="{{ route('admin.settings.update-email-templates') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="template_type" value="rejection">
                        
                        <div class="space-y-6">
                            <!-- Enable/Disable Toggle -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Template Status</h4>
                                    <p class="text-sm text-gray-500 mt-1">Enable or disable this email notification</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_rejection_notifications" value="1" class="sr-only peer" ${`{{ isset($settings['enable_rejection_notifications']) && $settings['enable_rejection_notifications']->value == '1' ? 'checked' : '' }}`}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Active</span>
                                </label>
                            </div>
                            
                            <!-- Email Subject -->
                            <div>
                                <label for="modal_rejection_email_subject" class="block text-sm font-medium text-gray-900 mb-2">
                                    Email Subject Line
                                </label>
                                <input 
                                    type="text" 
                                    id="modal_rejection_email_subject" 
                                    name="rejection_email_subject" 
                                    value="{{ old('rejection_email_subject', isset($settings['rejection_email_subject']) ? $settings['rejection_email_subject']->value : 'News Submission Rejected - {article_title}') }}"
                                    placeholder="News Submission Rejected - {article_title}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <p class="mt-2 text-xs text-gray-500">Available variables: {user_name}, {article_title}, {rejection_reason}, {platform_name}</p>
                            </div>
                            
                            <!-- Email Template -->
                            <div>
                                <label for="modal_rejection_email_template" class="block text-sm font-medium text-gray-900 mb-2">
                                    Email HTML Template
                                </label>
                                <textarea 
                                    id="modal_rejection_email_template" 
                                    name="rejection_email_template" 
                                    rows="15"
                                    placeholder="Enter your HTML email template here..."
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-mono text-xs">{{ old('rejection_email_template', isset($settings['rejection_email_template']) ? $settings['rejection_email_template']->value : '') }}</textarea>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs text-gray-500"><strong>Available variables:</strong></p>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{user_name}</code> - Recipient name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{user_email}</code> - Recipient email</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{article_title}</code> - Article title</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{article_excerpt}</code> - Article excerpt</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{status}</code> - Article status</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{rejection_reason}</code> - Rejection reason</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{rejected_at}</code> - Rejection date</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{dashboard_url}</code> - Dashboard link</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{university_name}</code> - University name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{rejector_name}</code> - Rejector name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{platform_name}</code> - Platform name</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                `;
            } else if (templateType === 'registration_received') {
                modalBody.innerHTML = `
                    <form id="templateForm" method="POST" action="{{ route('admin.settings.update-email-templates') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="template_type" value="registration_received">
                        
                        <div class="space-y-6">
                            <!-- Enable/Disable Toggle -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Template Status</h4>
                                    <p class="text-sm text-gray-500 mt-1">Enable or disable this email notification</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_registration_received_notifications" value="1" class="sr-only peer" ${`{{ isset($settings['enable_registration_received_notifications']) && $settings['enable_registration_received_notifications']->value == '1' ? 'checked' : '' }}`}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <!-- Email Subject -->
                            <div>
                                <label for="modal_registration_received_email_subject" class="block text-sm font-medium text-gray-900 mb-2">
                                    Email Subject Line
                                </label>
                                <input 
                                    type="text" 
                                    id="modal_registration_received_email_subject" 
                                    name="registration_received_email_subject" 
                                    value="{{ old('registration_received_email_subject', isset($settings['registration_received_email_subject']) ? $settings['registration_received_email_subject']->value : 'Registration Received - {university_name}') }}"
                                    placeholder="Registration Received - {university_name}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <p class="mt-2 text-xs text-gray-500">Available variables: {university_name}, {admin_name}, {platform_name}</p>
                            </div>
                            
                            <!-- Email Template -->
                            <div>
                                <label for="modal_registration_received_email_template" class="block text-sm font-medium text-gray-900 mb-2">
                                    Email HTML Template
                                </label>
                                <textarea 
                                    id="modal_registration_received_email_template" 
                                    name="registration_received_email_template" 
                                    rows="15"
                                    placeholder="Enter your HTML email template here..."
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-mono text-xs">{{ old('registration_received_email_template', isset($settings['registration_received_email_template']) ? $settings['registration_received_email_template']->value : '') }}</textarea>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs text-gray-500"><strong>Available variables:</strong></p>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{university_name}</code> - University name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{admin_name}</code> - Admin name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{admin_email}</code> - Admin email</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{contact_email}</code> - Contact email</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{platform_name}</code> - Platform name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{registered_at}</code> - Registration date</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                `;
            } else if (templateType === 'registration_approved') {
                modalBody.innerHTML = `
                    <form id="templateForm" method="POST" action="{{ route('admin.settings.update-email-templates') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="template_type" value="registration_approved">
                        
                        <div class="space-y-6">
                            <!-- Enable/Disable Toggle -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Template Status</h4>
                                    <p class="text-sm text-gray-500 mt-1">Enable or disable this email notification</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_registration_approved_notifications" value="1" class="sr-only peer" ${`{{ isset($settings['enable_registration_approved_notifications']) && $settings['enable_registration_approved_notifications']->value == '1' ? 'checked' : '' }}`}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <!-- Email Subject -->
                            <div>
                                <label for="modal_registration_approved_email_subject" class="block text-sm font-medium text-gray-900 mb-2">
                                    Email Subject Line
                                </label>
                                <input 
                                    type="text" 
                                    id="modal_registration_approved_email_subject" 
                                    name="registration_approved_email_subject" 
                                    value="{{ old('registration_approved_email_subject', isset($settings['registration_approved_email_subject']) ? $settings['registration_approved_email_subject']->value : 'Registration Approved - Welcome to {platform_name}!') }}"
                                    placeholder="Registration Approved - Welcome to {platform_name}!"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <p class="mt-2 text-xs text-gray-500">Available variables: {university_name}, {admin_name}, {platform_name}</p>
                            </div>
                            
                            <!-- Email Template -->
                            <div>
                                <label for="modal_registration_approved_email_template" class="block text-sm font-medium text-gray-900 mb-2">
                                    Email HTML Template
                                </label>
                                <textarea 
                                    id="modal_registration_approved_email_template" 
                                    name="registration_approved_email_template" 
                                    rows="15"
                                    placeholder="Enter your HTML email template here..."
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-mono text-xs">{{ old('registration_approved_email_template', isset($settings['registration_approved_email_template']) ? $settings['registration_approved_email_template']->value : '') }}</textarea>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs text-gray-500"><strong>Available variables:</strong></p>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{university_name}</code> - University name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{admin_name}</code> - Admin name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{admin_email}</code> - Admin email</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{contact_email}</code> - Contact email</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{platform_name}</code> - Platform name</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{approved_at}</code> - Approval date</div>
                                        <div><code class="bg-gray-100 px-1 py-0.5 rounded">{login_url}</code> - Login URL</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                `;
            }
            
            modal.classList.remove('hidden');
        }
        
        function closeTemplateEditor(event) {
            if (event && event.target.id !== 'templateEditorModal') {
                return;
            }
            const modal = document.getElementById('templateEditorModal');
            modal.classList.add('hidden');
        }
        
        function saveTemplate() {
            const form = document.getElementById('templateForm');
            if (form) {
                form.submit();
            }
        }
        
        let currentTestTemplateType = '';
        
        function sendTestEmail(templateType) {
            currentTestTemplateType = templateType;
            const modal = document.getElementById('testEmailModal');
            const resultDiv = document.getElementById('testEmailResult');
            
            // Reset result div
            resultDiv.classList.add('hidden');
            resultDiv.innerHTML = '';
            
            // Show modal
            modal.classList.remove('hidden');
        }
        
        function closeTestEmailModal(event) {
            if (event && event.target.id !== 'testEmailModal') {
                return;
            }
            const modal = document.getElementById('testEmailModal');
            modal.classList.add('hidden');
            currentTestTemplateType = '';
        }
        
        function sendTestEmailNow() {
            const emailInput = document.getElementById('test_recipient_email');
            const sendBtn = document.getElementById('sendTestBtn');
            const resultDiv = document.getElementById('testEmailResult');
            const email = emailInput.value.trim();
            
            // Validate email
            if (!email) {
                showTestEmailResult('error', 'Please enter an email address.');
                return;
            }
            
            if (!validateEmail(email)) {
                showTestEmailResult('error', 'Please enter a valid email address.');
                return;
            }
            
            // Disable button and show loading state
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<svg class="animate-spin w-4 h-4 inline-block mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending...';
            
            // Clear previous result
            resultDiv.classList.add('hidden');
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value;
            
            // Make AJAX request
            fetch('{{ route("admin.settings.send-test-email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    template_type: currentTestTemplateType,
                    recipient_email: email,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showTestEmailResult('success', data.message);
                    // Close modal after 2 seconds
                    setTimeout(() => {
                        closeTestEmailModal();
                    }, 2000);
                } else {
                    showTestEmailResult('error', data.message);
                }
            })
            .catch(error => {
                showTestEmailResult('error', 'An error occurred while sending the test email. Please try again.');
            })
            .finally(() => {
                // Re-enable button
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg> Send Test Email';
            });
        }
        
        function showTestEmailResult(type, message) {
            const resultDiv = document.getElementById('testEmailResult');
            resultDiv.classList.remove('hidden');
            
            if (type === 'success') {
                resultDiv.innerHTML = `
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <div class="flex">
                            <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-green-800">${message}</p>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-red-800">${message}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
        
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Load tab from URL hash on page load
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash.substring(1);
            if (hash && (hash === 'general' || hash === 'email-api' || hash === 'email-templates')) {
                switchTab(hash);
            } else {
                // Default to general tab
                switchTab('general');
            }
        });
    </script>
</x-admin-layout>

