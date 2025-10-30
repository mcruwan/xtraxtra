<x-error-layout>
    <div class="max-w-2xl w-full text-center">
        <!-- Error Icon/Illustration -->
        <div class="mb-8">
            <div class="mx-auto flex items-center justify-center w-32 h-32 bg-yellow-100 rounded-full mb-6">
                <svg class="w-16 h-16 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-6xl font-bold text-gray-900 mb-2">503</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Service Unavailable</h2>
        </div>

        <!-- Error Message -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <p class="text-lg text-gray-700 mb-6">
                We're currently performing maintenance. Please check back shortly.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.reload()" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Page
                </button>
                
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                        @csrf
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <button type="submit">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Log In
                    </a>
                @endauth
            </div>
        </div>

        <!-- Help Text -->
        <div class="text-sm text-gray-600">
            <p>We apologize for any inconvenience. We'll be back online soon.</p>
        </div>
    </div>
</x-error-layout>

