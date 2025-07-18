@props([
    'color',
])

<div {{ $attributes->class(['w-full', 'p-3',
                            'flex', 'items-center', 'gap-3',
                            'rounded-xl', 'border']) }}
     style="background-color: {{ $color }}26; color: {{ $color }}; border-color: {{ $color }}">

    {{ $slot }}

</div>
