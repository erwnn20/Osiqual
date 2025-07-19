@props([
    'legend',
    'required' => false,
])

<fieldset {{ $attributes->class(['grid', 'grid-cols-1', 'auto-rows-max', 'gap-3',
                                 'rounded-xl', 'p-4', 'pt-1',
                                 'bg-default-200/15', 'hover:bg-default-200/25',
                                  'border border-default-300',
                                  'transition-all', 'duration-200']) }}
    class="grid grid-cols-1 auto-rows-max gap-3
                rounded-xl p-4 pt-1
                bg-default-200/20 hover:bg-default-200/25
                border border-default-300">
    <legend class="text-xs font-semibold py-2 px-1">
        {{ $legend }}
        @if($required)
            <span id="{{ $name }}-required" class="font-normal text-error">*</span>
        @endif
    </legend>

    {{ $slot }}
</fieldset>
