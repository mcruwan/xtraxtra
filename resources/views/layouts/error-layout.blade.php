<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Error - {{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation Bar -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo/Brand -->
                    <div class="flex items-center">
                        @auth
                            @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                                    <span class="text-xl font-bold text-gray-900">AppliedHE Xtra! Xtra!</span>
                                </a>
                            @elseif(Auth::user()->isUniversityUser() && Auth::user()->university)
                                <a href="{{ route('university.dashboard') }}" class="flex items-center">
                                    <span class="text-xl font-bold text-gray-900">AppliedHE Xtra! Xtra!</span>
                                </a>
                            @else
                                <a href="{{ url('/') }}" class="flex items-center">
                                    <span class="text-xl font-bold text-gray-900">AppliedHE Xtra! Xtra!</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ url('/') }}" class="flex items-center">
                                <span class="text-xl font-bold text-gray-900">AppliedHE Xtra! Xtra!</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center gap-4">
                        @auth
                            <!-- User Info -->
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                                
                                <!-- Dashboard Link (if user has access) -->
                                @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        Admin Dashboard
                                    </a>
                                @elseif(Auth::user()->isUniversityUser() && Auth::user()->university)
                                    <a href="{{ route('university.dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        University Dashboard
                                    </a>
                                @endif
                                
                                <!-- Logout Button -->
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Login Link for guests -->
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                Log In
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Error Content -->
        <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} AppliedHE. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>

