<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register University - {{ config('app.name', 'AppliedHE') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: linear-gradient(135deg, #001da1 0%, #00096a 100%);">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-4xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2 drop-shadow-lg">Register Your University</h1>
                <p class="text-white/90">Submit your university for approval to start publishing news</p>
            </div>

            <div class="bg-white rounded-lg shadow-xl p-8 backdrop-blur-sm">
                <form method="POST" action="{{ route('university.register.store') }}" class="space-y-6">
                    @csrf

                    <!-- University Information Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            University Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- University Name -->
                            <div>
                                <label for="university_name" class="block mb-2 text-sm font-medium text-gray-900">
                                    University Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="university_name" 
                                       name="university_name" 
                                       value="{{ old('university_name') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('university_name') border-red-500 bg-red-50 @enderror" 
                                       placeholder="Enter university name" 
                                       required 
                                       autofocus>
                                @error('university_name')
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
                                       value="{{ old('domain') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('domain') border-red-500 bg-red-50 @enderror" 
                                       placeholder="e.g., university.edu">
                                @error('domain')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Email -->
                            <div class="md:col-span-2">
                                <label for="contact_email" class="block mb-2 text-sm font-medium text-gray-900">
                                    Contact Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="contact_email" 
                                       name="contact_email" 
                                       value="{{ old('contact_email') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('contact_email') border-red-500 bg-red-50 @enderror" 
                                       placeholder="contact@university.edu" 
                                       required>
                                @error('contact_email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Administrator Account Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Administrator Account
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Admin Name -->
                            <div>
                                <label for="admin_name" class="block mb-2 text-sm font-medium text-gray-900">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="admin_name" 
                                       name="admin_name" 
                                       value="{{ old('admin_name') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('admin_name') border-red-500 bg-red-50 @enderror" 
                                       placeholder="John Doe" 
                                       required>
                                @error('admin_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Admin Email -->
                            <div>
                                <label for="admin_email" class="block mb-2 text-sm font-medium text-gray-900">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="admin_email" 
                                       name="admin_email" 
                                       value="{{ old('admin_email') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('admin_email') border-red-500 bg-red-50 @enderror" 
                                       placeholder="admin@university.edu" 
                                       required>
                                @error('admin_email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="admin_password" class="block mb-2 text-sm font-medium text-gray-900">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       id="admin_password" 
                                       name="admin_password" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('admin_password') border-red-500 bg-red-50 @enderror" 
                                       placeholder="••••••••" 
                                       required>
                                @error('admin_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="admin_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       id="admin_password_confirmation" 
                                       name="admin_password_confirmation" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                                       placeholder="••••••••" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Info Alert - Flowbite -->
                    <div id="alert-info" class="flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-blue-100" role="alert">
                        <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Please note:</span> Your registration will be reviewed by an administrator before approval.
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline font-medium">
                            ← Already have an account?
                        </a>

                        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Submit Registration
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <p class="mt-6 text-center text-sm text-white/80">
                By registering, you agree to our 
                <a href="#" class="text-white hover:underline font-medium">Terms of Service</a> 
                and 
                <a href="#" class="text-white hover:underline font-medium">Privacy Policy</a>
            </p>
        </div>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
