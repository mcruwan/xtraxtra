@props([
    'title',
    'value',
    'color' => 'blue',
    'icon' => null,
    'link' => null,
    'linkText' => null,
])

@php
$colorClasses = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'orange' => 'bg-orange-500',
    'yellow' => 'bg-yellow-500',
    'purple' => 'bg-purple-500',
    'red' => 'bg-red-500',
];

$lightColorClasses = [
    'blue' => 'bg-blue-50',
    'green' => 'bg-green-50',
    'orange' => 'bg-orange-50',
    'yellow' => 'bg-yellow-50',
    'purple' => 'bg-purple-50',
    'red' => 'bg-red-50',
];

$textColorClasses = [
    'blue' => 'text-blue-700',
    'green' => 'text-green-700',
    'orange' => 'text-orange-700',
    'yellow' => 'text-yellow-700',
    'purple' => 'text-purple-700',
    'red' => 'text-red-700',
];

$bgClass = $lightColorClasses[$color] ?? $lightColorClasses['blue'];
$iconBgClass = $colorClasses[$color] ?? $colorClasses['blue'];
$textClass = $textColorClasses[$color] ?? $textColorClasses['blue'];
@endphp

<a @if($link) href="{{ $link }}" @else href="#" onclick="return false;" @endif class="block group h-full">
    <div class="bg-white rounded-lg border border-gray-200 p-3 hover:shadow-md hover:border-gray-300 transition-all duration-200 h-full flex flex-col">
        <div class="flex items-center justify-between flex-1">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide mb-2">{{ $title }}</p>
                <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
                <div class="mt-4">
                    @if($link && $linkText)
                        <p class="text-xs {{ $textClass }} group-hover:underline inline-flex items-center">
                            {{ $linkText }}
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </p>
                    @else
                        <span class="text-xs text-transparent">Placeholder</span>
                    @endif
                </div>
            </div>
            @if($icon)
                <div class="{{ $iconBgClass }} rounded-lg p-1.5 flex-shrink-0 ml-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                    </svg>
                </div>
            @endif
        </div>
    </div>
</a>

