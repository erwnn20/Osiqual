@props([
    'icon',
    'value'
])

<div class="w-full flex items-center gap-3 px-4 py-3 bg-default-50 rounded-xl">
    <i class="w-fit h-full " data-lucide="{{ $icon }}"></i>

    {{ $slot }}

    <span
        class="ms-auto px-2 py-0.5 rounded-lg text-base font-semibold tracking-wide bg-default-800/15 text-default-800">
        {{ $value }}
    </span>
</div>
