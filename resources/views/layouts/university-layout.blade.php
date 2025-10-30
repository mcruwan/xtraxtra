<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- University Navigation - Standard Flowbite Navbar -->
            <nav class="bg-gradient-to-r from-brand-900 via-brand-800 to-brand-900 border-b border-brand-700">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-3">
                    <!-- Logo -->
                    <a href="{{ route('university.dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                        <span class="self-center text-xl font-semibold whitespace-nowrap text-white">AppliedHE Xtra! Xtra!</span>
                    </a>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden md:flex md:items-center md:space-x-4 md:order-1">
                        <a href="{{ route('university.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('university.dashboard') ? 'bg-brand-700 text-white' : 'text-blue-100 hover:bg-brand-700 hover:text-white' }} transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('university.news.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('university.news.*') ? 'bg-brand-700 text-white' : 'text-blue-100 hover:bg-brand-700 hover:text-white' }} transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            News Submissions
                        </a>
                        <a href="{{ route('university.faqs.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('university.faqs.*') ? 'bg-brand-700 text-white' : 'text-blue-100 hover:bg-brand-700 hover:text-white' }} transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            FAQs
                        </a>
                    </div>

                    <!-- Right Side: User Menu & Mobile Button -->
                    <div class="flex items-center md:order-2 space-x-3 rtl:space-x-reverse">
                        <!-- University Name (Desktop) -->
                        @if(Auth::user()->university)
                        <div class="hidden md:flex items-center text-sm text-blue-200 mr-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            {{ Auth::user()->university->name }}
                        </div>
                        @endif

                        <!-- User Dropdown -->
                        <button type="button" class="flex text-sm bg-brand-700 rounded-lg focus:ring-4 focus:ring-brand-300 px-3 py-2 text-white hover:bg-brand-600 transition-colors" id="dropdownUserButton" data-dropdown-toggle="dropdownUser" data-dropdown-placement="bottom">
                            <span class="sr-only">Open user menu</span>
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44" id="dropdownUser">
                            <div class="px-4 py-3">
                                <span class="block text-sm text-gray-900 font-medium">{{ Auth::user()->name }}</span>
                                <span class="block text-sm text-gray-500 truncate">{{ Auth::user()->email }}</span>
                                @if(Auth::user()->university)
                                <div class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ Auth::user()->university->name }}
                                </div>
                                @endif
                            </div>
                            <ul class="py-2" aria-labelledby="dropdownUserButton">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('profile.edit') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-700' }} hover:bg-gray-100 transition-colors">Profile</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Log Out</a>
                                </form>
                            </div>
                        </div>

                        <!-- Mobile Menu Button (hidden on desktop) -->
                        <button data-collapse-toggle="navbar-default" type="button" class="flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-300" aria-controls="navbar-default" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Navigation Menu (Hidden on desktop, visible when toggled on mobile) -->
                    <div class="hidden w-full md:hidden" id="navbar-default">
                        <ul class="font-medium flex flex-col p-4 mt-4 border border-brand-700 rounded-lg bg-brand-800 space-y-1">
                            <li>
                                <a href="{{ route('university.dashboard') }}" class="flex items-center gap-2 py-2 px-3 rounded {{ request()->routeIs('university.dashboard') ? 'text-white bg-brand-700' : 'text-blue-100 hover:bg-brand-700 hover:text-white' }}" aria-current="page">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('university.news.index') }}" class="flex items-center gap-2 py-2 px-3 rounded {{ request()->routeIs('university.news.*') ? 'text-white bg-brand-700' : 'text-blue-100 hover:bg-brand-700 hover:text-white' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    News Submissions
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('university.faqs.index') }}" class="flex items-center gap-2 py-2 px-3 rounded {{ request()->routeIs('university.faqs.*') ? 'text-white bg-brand-700' : 'text-blue-100 hover:bg-brand-700 hover:text-white' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    FAQs
                                </a>
                            </li>
                            <!-- Mobile User Info -->
                            <li>
                                <div class="pt-4 pb-3 border-t border-brand-700">
                                    <div class="px-3 mb-2">
                                        <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                                        <div class="text-sm font-medium text-blue-200">{{ Auth::user()->email }}</div>
                                        @if(Auth::user()->university)
                                        <div class="text-xs text-blue-300 mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ Auth::user()->university->name }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="px-3 space-y-1">
                                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('profile.edit') ? 'bg-brand-700 text-white' : 'text-blue-100 hover:bg-brand-700 hover:text-white' }} transition-colors">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-3 py-2 rounded-lg text-base font-medium text-blue-100 hover:bg-brand-700 hover:text-white transition-colors">Log Out</a>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <!-- Flowbite JS for interactive components -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite/dist/flowbite.min.js"></script>
        
        <!-- Chart.js for analytics visualizations -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        
        @stack('scripts')
    </body>
</html>

