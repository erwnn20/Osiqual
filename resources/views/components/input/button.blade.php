@props([
    'type',
    'name',
    'label' => null,
    'value' => null,
    'assistiveText' => null,
    'error' => null,
    'title' => null,
    'data' => [],

    'autofocus' => false,
    'disabled' => false,

    'icon' => null,
    'size' => null,
    'color' => null,
])

<div id="{{ $name .'-container' }}" {{ $attributes->class(['flex', 'flex-col', 'gap-1']) }}>

    <div @class(['flex', 'gap-1.5', 'items-baseline' => !$error , 'items-center' => $error, 'w-fit'])>
        @if($label)
            <label for="{{ $name }}" class="text-sm font-medium text-default-700">
                {{ $label }}
            </label>
        @endif
        @if($error)
            <div class="flex items-center gap-1 h-full">
                <i class="h-3.5 w-fit text-error" data-lucide="circle-alert"></i>
                <p class="text-[11px] tracking-wide italic text-error">{{ $error }}</p>
            </div>
        @elseif($assistiveText)
            <p class="text-[11px] tracking-wide italic text-default-500">{{ $assistiveText }}</p>
        @endif
    </div>

    <x-button
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        :title="$title"
        :data="$data"

        :autofocus="$autofocus"
        :disabled="$disabled"

        :icon="$icon"
        :size="$size"
        :color="$color"
    >
        {{ $value }}
    </x-button>

</div>
