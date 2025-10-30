<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen">
            <!-- Left Sidebar - Flowbite Admin Sidebar Template -->
            <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" aria-label="Sidebar">
                <div class="h-full px-3 py-4 overflow-y-auto bg-gray-800 flex flex-col">
                    <!-- Sidebar Header -->
                    <div class="flex items-center justify-between mb-5 px-3 pt-3 pb-3 border-b border-gray-700 flex-shrink-0">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center w-full">
                            @if(\App\Models\Setting::getLightLogo())
                                <img src="{{ \App\Models\Setting::getLightLogo() }}" 
                                     alt="Admin Panel Logo" 
                                     class="w-full h-auto object-contain">
                            @else
                                <span class="text-lg font-bold text-white">AppliedHE Xtra! Xtra!</span>
                            @endif
                        </a>
                        <!-- Close button for mobile -->
                        <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg p-1.5" aria-label="Close sidebar">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation Links - Flowbite Sidebar Items (Flexible space) -->
                    <ul class="space-y-2 font-medium flex-1 overflow-y-auto">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg>
                                <span class="ms-3">Dashboard</span>
                            </a>
                        </li>

                        <!-- News Submissions -->
                        <li>
                            <a href="{{ route('admin.news.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.news.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.news.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">News Submissions</span>
                                @if(isset($pendingNewsCount) && $pendingNewsCount > 0)
                                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-orange-800 bg-orange-100 rounded-full">{{ $pendingNewsCount }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- Universities -->
                        <li>
                            <a href="{{ route('admin.universities.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.universities.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.universities.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="ms-3">Universities</span>
                            </a>
                        </li>

                        <!-- University Users -->
                        <li>
                            <a href="{{ route('admin.university-users.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.university-users.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.university-users.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 009.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="ms-3">University Users</span>
                            </a>
                        </li>

                        <!-- Admin Users (Super Admin Only) -->
                        @if(auth()->user()->isSuperAdmin())
                        <li>
                            <a href="{{ route('admin.admin-users.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.admin-users.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.admin-users.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="ms-3">Admin Users</span>
                            </a>
                        </li>
                        @endif

                        <!-- News Categories -->
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.categories.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="ms-3">News Categories</span>
                            </a>
                        </li>

                        <!-- Support Tickets -->
                        <li>
                            <a href="{{ route('admin.tickets.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.tickets.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.tickets.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Support Tickets</span>
                                @php
                                    $openTicketsCount = \App\Models\Ticket::open()->count();
                                @endphp
                                @if($openTicketsCount > 0)
                                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">{{ $openTicketsCount }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- FAQs -->
                        <li>
                            <a href="{{ route('admin.faqs.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.faqs.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.faqs.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="ms-3">FAQs</span>
                            </a>
                        </li>

                        <!-- Settings -->
                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-700 hover:text-white' }} group">
                                <svg class="w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white {{ request()->routeIs('admin.settings.*') ? 'text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="ms-3">Settings</span>
                            </a>
                        </li>
                    </ul>

                    <!-- User Profile Section - Fixed at bottom -->
                    <div class="pt-4 mt-auto border-t border-gray-700 flex-shrink-0">
                        <div x-data="{ profileOpen: false }" class="relative">
                            <button @click="profileOpen = !profileOpen" type="button" class="flex items-center w-full p-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white group">
                                <div class="flex items-center justify-center w-8 h-8 mr-3 bg-blue-600 text-white rounded-full text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <div class="flex-1 text-left min-w-0">
                                    <div class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-400">Super Admin</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu - Flowbite Dropdown -->
                            <div x-show="profileOpen" @click.away="profileOpen = false" x-transition class="absolute bottom-full left-0 right-0 mb-2 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-200 overflow-hidden">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profile Settings
                                    </a>
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Mobile Top Bar - Flowbite Styled -->
            <div class="lg:hidden fixed top-0 left-0 right-0 z-40 h-16 bg-gray-800 border-b border-gray-700 flex items-center justify-between px-4">
                <button @click="sidebarOpen = true" type="button" class="inline-flex items-center p-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <div class="flex items-center flex-1 justify-center">
                    @if(\App\Models\Setting::getLightLogo())
                        <img src="{{ \App\Models\Setting::getLightLogo() }}" 
                             alt="Admin Panel Logo" 
                             class="h-8 w-auto object-contain max-w-full">
                    @else
                        <span class="text-white font-bold text-lg">Admin Panel</span>
                    @endif
                </div>
                <div class="w-6"></div>
            </div>

            <!-- Overlay for mobile - Flowbite Backdrop -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-gray-900/50 backdrop-blur-sm lg:hidden" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <!-- Main Content Area -->
            <div class="lg:pl-64 pt-16 lg:pt-0">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white border-b border-gray-200 shadow-sm">
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
        </div>
        
        <!-- Flowbite JS for interactive components -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite/dist/flowbite.min.js"></script>
        
        <!-- Chart.js for analytics visualizations -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        
        @stack('scripts')
    </body>
</html>
