@php use Illuminate\Support\Str; @endphp
@props([
    'head' => false,
    'color',
])

@php $color = Str::lower($color); @endphp

<x-table.element :head="$head" {{ $attributes }}>
    <span class="px-2 py-0.5 rounded text-xs font-semibold tracking-wide uppercase"
          style="background-color: {{ $color }}26; color: {{ $color }}">
        {{ $slot }}
    </span>
</x-table.element>

