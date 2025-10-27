<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- University Navigation -->
            <nav x-data="{ open: false }" class="bg-gradient-to-r from-brand-900 via-brand-800 to-brand-900 shadow-lg border-b border-brand-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('university.dashboard') }}" class="text-xl font-bold text-white hover:text-gray-200 transition-colors">
                                    AppliedHE Xtra! Xtra!
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex items-center h-full">
                                <a href="{{ route('university.dashboard') }}" class="inline-flex items-center h-full px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('university.dashboard') ? 'border-white text-white font-semibold' : 'border-transparent text-blue-100 hover:text-white hover:border-blue-300' }} transition-all duration-150">
                                    {{ __('Dashboard') }}
                                </a>
                                <a href="{{ route('university.news.index') }}" class="inline-flex items-center h-full px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('university.news.*') ? 'border-white text-white font-semibold' : 'border-transparent text-blue-100 hover:text-white hover:border-blue-300' }} transition-all duration-150">
                                    {{ __('News Submissions') }}
                                </a>
                            </div>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- University Name -->
                            @if(Auth::user()->university)
                            <div class="text-sm text-blue-200 me-4 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ Auth::user()->university->name }}
                            </div>
                            @endif

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-brand-600 text-sm leading-4 font-medium rounded-md text-blue-100 bg-brand-800 hover:bg-brand-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-brand-400 transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-100 hover:text-white hover:bg-brand-700 focus:outline-none focus:bg-brand-700 focus:text-white transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-brand-800 border-t border-brand-700">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('university.dashboard') }}" class="block pl-3 pr-4 py-3 border-l-4 {{ request()->routeIs('university.dashboard') ? 'border-white text-white bg-brand-700/50 font-semibold' : 'border-transparent text-blue-100 hover:text-white hover:bg-brand-700/30 hover:border-blue-300' }} text-base transition duration-150 ease-in-out">
                            {{ __('Dashboard') }}
                        </a>
                        <a href="{{ route('university.news.index') }}" class="block pl-3 pr-4 py-3 border-l-4 {{ request()->routeIs('university.news.*') ? 'border-white text-white bg-brand-700/50 font-semibold' : 'border-transparent text-blue-100 hover:text-white hover:bg-brand-700/30 hover:border-blue-300' }} text-base transition duration-150 ease-in-out">
                            {{ __('News Submissions') }}
                        </a>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-brand-700">
                        <div class="px-4">
                            <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
                            @if(Auth::user()->university)
                            <div class="font-medium text-xs text-blue-300 mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ Auth::user()->university->name }}
                            </div>
                            @endif
                        </div>

                        <div class="mt-3 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-blue-100 hover:text-white hover:bg-brand-700 hover:border-brand-500 transition duration-150 ease-in-out">
                                {{ __('Profile') }}
                            </a>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-blue-100 hover:text-white hover:bg-brand-700 hover:border-brand-500 transition duration-150 ease-in-out">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
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
    </body>
</html>

