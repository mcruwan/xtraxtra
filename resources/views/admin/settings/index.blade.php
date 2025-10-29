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

            <!-- Settings Sections -->
            <div class="space-y-6">
                <!-- Platform Logo Section -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Platform Logo</h2>
                        <p class="mt-1 text-sm text-gray-600">Upload your platform logo to be displayed in the header</p>
                    </div>
                    <div class="p-6">
                        <!-- Current Logo Display -->
                        @php
                            $currentLogo = $settings['platform_logo'] ?? null;
                        @endphp

                        @if($currentLogo && $currentLogo->value)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-900 mb-3">Current Logo</label>
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 bg-gray-100 rounded-lg p-4 border border-gray-200">
                                        <img src="{{ Storage::url($currentLogo->value) }}" alt="Platform Logo" class="h-24 w-auto object-contain">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <form action="{{ route('admin.settings.logo.remove') }}" method="POST" onsubmit="return confirm('Are you sure you want to remove the current logo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Remove Logo
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Upload a new logo to replace the current one</p>
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
                                        <p class="mt-2 text-sm text-gray-600 font-medium">No logo uploaded yet</p>
                                        <p class="text-xs text-gray-500">Upload your platform logo below</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Upload Form -->
                        <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="platform_logo" class="block text-sm font-medium text-gray-900 mb-2">
                                        {{ ($currentLogo && $currentLogo->value) ? 'Upload New Logo' : 'Upload Logo' }}
                                        @if($errors->has('platform_logo'))
                                            <span class="text-red-600 font-normal">*</span>
                                        @endif
                                    </label>
                                    <input 
                                        type="file" 
                                        id="platform_logo" 
                                        name="platform_logo" 
                                        accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml"
                                        class="block w-full text-sm text-gray-900 border {{ $errors->has('platform_logo') ? 'border-red-500' : 'border-gray-300' }} rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2.5 file:px-4 file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    @error('platform_logo')
                                        <x-input-error :messages="$errors->get('platform_logo')" class="mt-2" />
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">Supported formats: JPG, JPEG, PNG, GIF, SVG. Maximum size: 2MB</p>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                        Upload Logo
                                    </button>
                                </div>
                            </div>
                        </form>
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

                <!-- More Settings Sections (Placeholder for future expansion) -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-900 mb-1">More Settings Coming Soon</h3>
                            <p class="text-sm text-blue-700">Additional settings sections will be added here as needed. This area is designed to be expandable for future configuration options.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

