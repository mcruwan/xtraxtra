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
    'blue' => 'bg-blue-50 border-blue-200',
    'green' => 'bg-green-50 border-green-200',
    'orange' => 'bg-orange-50 border-orange-200',
    'yellow' => 'bg-yellow-50 border-yellow-200',
    'purple' => 'bg-purple-50 border-purple-200',
    'red' => 'bg-red-50 border-red-200',
];

$textColorClasses = [
    'blue' => 'text-blue-600',
    'green' => 'text-green-600',
    'orange' => 'text-orange-600',
    'yellow' => 'text-yellow-600',
    'purple' => 'text-purple-600',
    'red' => 'text-red-600',
];

$valueColorClasses = [
    'blue' => 'text-blue-900',
    'green' => 'text-green-900',
    'orange' => 'text-orange-900',
    'yellow' => 'text-yellow-900',
    'purple' => 'text-purple-900',
    'red' => 'text-red-900',
];

$bgClass = $colorClasses[$color] ?? $colorClasses['blue'];
$textClass = $textColorClasses[$color] ?? $textColorClasses['blue'];
$valueClass = $valueColorClasses[$color] ?? $valueColorClasses['blue'];
@endphp

<div class="{{ $bgClass }} p-6 rounded-xl border shadow-sm hover:shadow-md transition-shadow duration-200">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-2">
                @if($icon)
                    <span class="{{ $textClass }}">
                        {!! $icon !!}
                    </span>
                @endif
                <h3 class="text-sm font-medium {{ $textClass }}">{{ $title }}</h3>
            </div>
            <p class="text-3xl font-bold {{ $valueClass }}">{{ $value }}</p>
            @if($link && $linkText)
                <a href="{{ $link }}" class="inline-flex items-center text-xs {{ $textClass }} hover:underline mt-3">
                    {{ $linkText }}
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>

