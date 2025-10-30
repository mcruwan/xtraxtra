<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AppliedHE Xtra! Xtra!') }}</title>
            @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav style="background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);" class="border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-white">AppliedHE Xtra! Xtra!</span>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200 font-medium">Dashboard</a>
        @else
                                <a href="{{ route('login') }}" class="text-white hover:text-gray-200 font-medium">Login</a>
                                <a href="{{ route('university.register.create') }}" class="bg-white text-blue-700 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Register</a>
                            @endauth
        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="flex-1 flex items-center justify-center px-4 py-12">
            <div class="max-w-4xl mx-auto text-center">
                @if(\App\Models\Setting::getDarkLogo())
                    <div class="mb-8">
                        <img src="{{ \App\Models\Setting::getDarkLogo() }}" 
                             alt="AppliedHE Xtra! Xtra! Logo" 
                             class="h-32 md:h-36 w-auto object-contain mx-auto">
                    </div>
                @endif
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                    News Management Portal
                </h1>
                <h3 class="text-2xl md:text-3xl font-medium text-gray-700 mb-8">
                    Streamline Your University News Workflow
                </h3>
                <p class="text-lg md:text-xl text-gray-600 mb-12 leading-relaxed max-w-3xl mx-auto">
                    A comprehensive news management platform designed for universities and educational institutions. 
                    Streamline news submission, categorization, and publication workflows with our intuitive interface. 
                    Connect universities, manage content, and deliver timely news to your academic community.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-gray-900 hover:bg-black focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg">
                                Go to Dashboard
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-gray-900 hover:bg-black focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg">
                                Sign In
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                            </a>
                            <a href="{{ route('university.register.create') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg border border-gray-300">
                                Register University
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </a>
                        @endauth
                    @endif
                </div>

                <!-- Features Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
                    <!-- Feature Card 1 -->
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-center w-12 h-12 bg-gray-900 rounded-lg mb-4 mx-auto">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Submit Your News</h3>
                        <p class="text-gray-600">Share your university's latest achievements, events, and announcements with a simple submission process. Upload articles, images, and relevant details in just a few steps.</p>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-center w-12 h-12 bg-gray-900 rounded-lg mb-4 mx-auto">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Track Your Submissions</h3>
                        <p class="text-gray-600">Monitor the status of all your news submissions in real-time. Know when your articles are under review, approved, or if any changes are requested.</p>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-center w-12 h-12 bg-gray-900 rounded-lg mb-4 mx-auto">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Reach Your Audience</h3>
                        <p class="text-gray-600">Get your university's news stories published and recognized through our platform. Connect with the educational community and showcase your institution's achievements.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer style="background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);" class="border-t border-white/10 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-white/80 text-sm mb-4 md:mb-0">
                        © {{ date('Y') }} AppliedHE Xtra! Xtra!. All rights reserved.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-white/80 hover:text-white text-sm">Privacy Policy</a>
                        <a href="#" class="text-white/80 hover:text-white text-sm">Terms of Service</a>
                        <a href="#" class="text-white/80 hover:text-white text-sm">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite/dist/flowbite.min.js"></script>
    </body>
</html>
