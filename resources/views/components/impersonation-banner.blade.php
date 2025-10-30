@if(session()->has('impersonating') && session('impersonating'))
<div style="background: linear-gradient(to right, #9333ea, #7e22ce); color: white;" class="shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-3 flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <svg style="color: white;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p style="color: white;" class="text-sm font-semibold">
                        Admin Impersonation Mode
                    </p>
                    <p style="color: white;" class="text-xs opacity-90">
                        You are viewing as: <span class="font-medium">{{ auth()->user()->name }}</span> 
                        @if(auth()->user()->university)
                            from <span class="font-medium">{{ auth()->user()->university->name }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <form method="POST" action="{{ route('stop-impersonating') }}" class="inline">
                    @csrf
                    <button type="submit" style="background-color: white; color: #9333ea;" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-purple-50 focus:ring-4 focus:ring-purple-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Return to Admin
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

