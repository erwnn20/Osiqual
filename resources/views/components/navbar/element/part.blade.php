@props([
    'title' => null,
])

<div {{ $attributes->class(['py-3', 'flex', 'flex-col', 'gap-1']) }}>
    @if($title)
        <span class="sticky top-0 pb-1
                     bg-linear-to-b from-default-50 from-65% to-transparent
                     text-default-500 text-xs italic">
            {{ $title }}
        </span>
    @endif
    {{ $slot }}
</div>
