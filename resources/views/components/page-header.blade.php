@props([
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'mb-8']) }}>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $title }}</h1>
            @if($description)
                <p class="mt-2 text-sm text-gray-600">{{ $description }}</p>
            @endif
        </div>
        @isset($actions)
            <div class="flex items-center gap-3">
                {{ $actions }}
            </div>
        @endisset
    </div>
</div>

