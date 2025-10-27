@props([
    'status',
    'type' => 'default',
    'size' => 'md',
])

@php
$statusConfig = [
    'pending' => [
        'bg' => 'bg-orange-100',
        'text' => 'text-orange-800',
        'ring' => 'ring-orange-600/20',
        'label' => 'Pending',
    ],
    'active' => [
        'bg' => 'bg-green-100',
        'text' => 'text-green-800',
        'ring' => 'ring-green-600/20',
        'label' => 'Active',
    ],
    'inactive' => [
        'bg' => 'bg-gray-100',
        'text' => 'text-gray-800',
        'ring' => 'ring-gray-600/20',
        'label' => 'Inactive',
    ],
    'approved' => [
        'bg' => 'bg-green-100',
        'text' => 'text-green-800',
        'ring' => 'ring-green-600/20',
        'label' => 'Approved',
    ],
    'rejected' => [
        'bg' => 'bg-red-100',
        'text' => 'text-red-800',
        'ring' => 'ring-red-600/20',
        'label' => 'Rejected',
    ],
    'draft' => [
        'bg' => 'bg-gray-100',
        'text' => 'text-gray-800',
        'ring' => 'ring-gray-600/20',
        'label' => 'Draft',
    ],
    'published' => [
        'bg' => 'bg-blue-100',
        'text' => 'text-blue-800',
        'ring' => 'ring-blue-600/20',
        'label' => 'Published',
    ],
];

$sizeClasses = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-xs',
    'lg' => 'px-3 py-1.5 text-sm',
];

$config = $statusConfig[$status] ?? $statusConfig['pending'];
$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<span class="inline-flex items-center {{ $sizeClass }} font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }} ring-1 ring-inset {{ $config['ring'] }}">
    {{ $config['label'] }}
</span>

