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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Email & API
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

                <!-- Future tabs content can be added here -->
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
            const apiKeyInput = document.getElementById('bravo_api_key');
            const apiSecretInput = document.getElementById('bravo_api_secret');
            const baseUrlInput = document.getElementById('bravo_api_base_url');
            const testBtn = document.getElementById('test-api-key-btn');
            const resultDiv = document.getElementById('api-test-result');
            
            const apiKey = apiKeyInput.value.trim();
            const apiSecret = apiSecretInput.value.trim();
            const baseUrl = baseUrlInput.value.trim();
            
            if (!apiKey) {
                showTestResult('error', 'Please enter an API key first.');
                return;
            }
            
            // Disable button and show loading state
            testBtn.disabled = true;
            testBtn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Testing...';
            
            // Clear previous result
            resultDiv.classList.add('hidden');
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value;
            
            // Make AJAX request
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
            .then(response => response.json())
            .then(data => {
                // Re-enable button
                testBtn.disabled = false;
                testBtn.innerHTML = '<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Test API Key';
                
                if (data.success) {
                    let accountInfo = '';
                    if (data.account) {
                        accountInfo = '<div class="mt-2 text-xs text-gray-700 space-y-1">';
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
                    showTestResult('success', data.message + accountInfo);
                } else {
                    showTestResult('error', data.message || 'API key test failed.');
                }
            })
            .catch(error => {
                // Re-enable button
                testBtn.disabled = false;
                testBtn.innerHTML = '<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Test API Key';
                
                showTestResult('error', 'An error occurred while testing the API key. Please try again.');
                console.error('API test error:', error);
            });
        }
        
        function showTestResult(type, message) {
            const resultDiv = document.getElementById('api-test-result');
            resultDiv.classList.remove('hidden');
            
            if (type === 'success') {
                resultDiv.className = 'mt-2 p-3 bg-green-50 border border-green-200 rounded-lg';
                resultDiv.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-green-900 mb-1">Success!</h4>
                            <div class="text-sm text-green-800">${message}</div>
                        </div>
                    </div>
                `;
            } else {
                resultDiv.className = 'mt-2 p-3 bg-red-50 border border-red-200 rounded-lg';
                resultDiv.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-red-900 mb-1">Test Failed</h4>
                            <div class="text-sm text-red-800">${message}</div>
                        </div>
                    </div>
                `;
            }
        }

        // Load tab from URL hash on page load
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash.substring(1);
            if (hash && (hash === 'general' || hash === 'email-api')) {
                switchTab(hash);
            } else {
                // Default to general tab
                switchTab('general');
            }
        });
    </script>
</x-admin-layout>

