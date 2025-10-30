<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Storage Diagnostics') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Overall Status -->
            @if($allGood)
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-green-900">All Systems Operational</h3>
                            <p class="text-sm text-green-700">Storage is properly configured. Uploaded images should work correctly.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-900">Issues Detected</h3>
                            <p class="text-sm text-yellow-700">Some storage issues were found. Please review the details below.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Diagnostic Results -->
            <div class="space-y-4">
                @foreach($diagnostics as $key => $diagnostic)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                            <h3 class="text-base font-semibold text-gray-900 capitalize flex items-center">
                                @if($diagnostic['status'] === 'success')
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif($diagnostic['status'] === 'warning')
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                                {{ str_replace('_', ' ', $key) }}
                            </h3>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($diagnostic['status'] === 'success') bg-green-100 text-green-800
                                @elseif($diagnostic['status'] === 'warning') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ strtoupper($diagnostic['status']) }}
                            </span>
                        </div>
                        <div class="p-4">
                            <p class="text-sm font-medium text-gray-900 mb-2">{{ $diagnostic['message'] }}</p>
                            
                            @if(is_array($diagnostic['details']))
                                <div class="bg-gray-50 rounded p-3 text-xs text-gray-700 space-y-1">
                                    @foreach($diagnostic['details'] as $detailKey => $detailValue)
                                        @if(is_array($detailValue))
                                            <div class="mb-2 pb-2 border-b border-gray-200 last:border-0">
                                                @foreach($detailValue as $k => $v)
                                                    <div><strong>{{ $k }}:</strong> {{ is_bool($v) ? ($v ? 'Yes' : 'No') : $v }}</div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div><strong>{{ $detailKey }}:</strong> {{ is_bool($detailValue) ? ($detailValue ? 'Yes' : 'No') : $detailValue }}</div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-600 bg-gray-50 rounded p-3">{{ $diagnostic['details'] }}</p>
                            @endif

                            @if(isset($diagnostic['fix']))
                                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded">
                                    <p class="text-xs font-semibold text-blue-900 mb-1">How to Fix:</p>
                                    <code class="text-xs text-blue-800">{{ $diagnostic['fix'] }}</code>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="text-base font-semibold text-blue-900 mb-3">Quick Actions</h3>
                <div class="space-y-2 text-sm text-blue-800">
                    <p>• To create storage symlink: <code class="bg-blue-100 px-2 py-1 rounded">php artisan storage:link</code></p>
                    <p>• To clear Laravel cache: <code class="bg-blue-100 px-2 py-1 rounded">php artisan cache:clear</code></p>
                    <p>• To check logs: <code class="bg-blue-100 px-2 py-1 rounded">storage/logs/laravel.log</code></p>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('admin.universities.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Back to Universities
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>

