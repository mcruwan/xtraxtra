<x-error-layout>
    <div class="max-w-2xl w-full text-center">
        <!-- Error Icon/Illustration -->
        <div class="mb-8">
            <div class="mx-auto flex items-center justify-center w-32 h-32 bg-red-100 rounded-full mb-6">
                <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h1 class="text-6xl font-bold text-gray-900 mb-2">403</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Forbidden</h2>
        </div>

        <!-- Error Message -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <p class="text-lg text-gray-700 mb-6">
                @if(isset($exception) && $exception->getMessage())
                    {{ $exception->getMessage() }}
                @else
                    You don't have permission to access this resource.
                @endif
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Go to Admin Dashboard
                        </a>
                    @elseif(Auth::user()->isUniversityUser() && Auth::user()->university)
                        <a href="{{ route('university.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Go to University Dashboard
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 transition-colors">
                        @csrf
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <button type="submit">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Log In
                    </a>
                @endauth
                
                <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Go Back
                </a>
            </div>
        </div>

        <!-- Help Text -->
        <div class="text-sm text-gray-600">
            <p>If you believe this is an error, please contact your administrator.</p>
        </div>
    </div>
</x-error-layout>

