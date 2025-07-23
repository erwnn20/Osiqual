@props([
    'active' => false,
    'icon' => null,
    'size' => 'md',
])

@php
    $sizes = [
        'md' => [
            'text' => 'text-base',
            'icon' => 'h-5'
        ],
        'sm' => [
            'text' => 'text-sm text-default-700',
            'icon' => 'h-4'
        ],
    ]
@endphp

<a {{ $attributes->class([
        'p-2', 'flex', 'gap-1.5', 'items-center',
        'rounded-md', 'font-semibold', $sizes[$size]['text'],
        'transition-all', 'duration-200',
        'hover:text-primary', 'hover:bg-primary/10',
        'focus:text-primary', 'focus:bg-primary/10', 'focus:outline-none',
        'text-primary' => $active, 'bg-primary/15' => $active,
        'sticky top-5 backdrop-blur-md' => $active,
    ]) }}>
    @if($icon)
        <i class="{{ $sizes[$size]['icon'] }} stroke-2" data-lucide="{{ $icon }}"></i>
    @endif
    {{ $slot }}
</a>
