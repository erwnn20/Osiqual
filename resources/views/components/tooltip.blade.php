@props([
    'title'
])

<div {{ $attributes->class(['relative', 'inline-block', 'group']) }}>
    {{ $slot }}

    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1
                 scale-95 opacity-0 transition-all duration-200
                 group-hover:opacity-100 group-hover:scale-100
                 bg-zinc-800/80 text-white rounded px-2 py-1
                 text-xs whitespace-nowrap">
        {{ $title }}
    </span>
</div>
