@php use Carbon\Carbon; @endphp
@props([
    'head' => false,

    'date',
])

<x-table.element :head="$head" {{ $attributes }}>
    @if($date)
        <span>{{ Carbon::parse($date)->format('d/m/Y') }}</span>
    @else
        <span>-</span>
    @endif
</x-table.element>
