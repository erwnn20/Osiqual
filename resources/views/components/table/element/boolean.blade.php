@props([
    'head' => false,
    'valid',
])

<x-table.element :head="$head" {{ $attributes }}>
    <i @class(['h-5', 'w-fit', 'stroke-3', 'text-valid' => $valid, 'text-error' => !$valid])
       data-lucide="{{ $valid ? 'check' : 'x' }}"></i>
</x-table.element>

