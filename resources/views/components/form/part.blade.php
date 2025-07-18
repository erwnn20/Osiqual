@props([
    'title' => '',
    'submit' => null,
])

<div {{ $attributes->class(['flex', 'flex-col', 'gap-3']) }}>
    <div class="flex items-baseline">
        @if($title)
            <h3 class="text-2xl/tight font-bold">{{ $title }}</h3>
        @endif

        @if($submit)
            <x-button type="submit" :icon="$submit['icon'] ?? null" size="md" class="ms-auto">
                {{ $submit['text'] }}
            </x-button>
        @endif
    </div>

    <div class="p-5 flex flex-col gap-4
                bg-default-50 shadow-lg rounded-xl">

        {{ $slot }}

    </div>

</div>
