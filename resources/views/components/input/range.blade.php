@props([
    'name',
    'label' => null,
    'value' => 50,
    'assistiveText' => null,
    'error' => null,
    'title' => null,
    'data' => [],

    'autocomplete' => null,
    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,

    'min' => 0,
    'max' => 100,
    'step' => null,
])

@php $min = is_numeric($min) ? $min : 0 @endphp
@php $value = is_numeric($value) ? $value : $min + ($max - $min) * 0.5 @endphp
@php $max = is_numeric($max) ? $max : $min + 100 @endphp
@php if($readonly) $data['readonly'] = $readonly @endphp

<div id="{{ $name .'-container' }}" {{ $attributes->class(['flex', 'flex-col', 'gap-1']) }}>

    <div class="relative flex mb-0.5">
        <div @class(['label-container', 'flex', 'gap-2', 'w-fit',
                 'items-baseline' => !$error , 'items-center' => $error,
                 'pe-2.5' => $label || $required || $error || $assistiveText])>
            @if($label || $required)
                <label for="{{ $name }}" class="text-sm font-medium text-default-700">
                    {{ $label }}
                    @if($required)
                        <span id="{{ $name }}-required" class="font-normal text-error">*</span>
                    @endif
                </label>
            @endif
            @if($error)
                <div class="flex items-center gap-1 h-full">
                    <i class="h-3.5 w-fit text-error" data-lucide="circle-alert"></i>
                    <p class="text-[11px] tracking-wide italic text-error">{{ $error }}</p>
                </div>
            @elseif($assistiveText)
                <p class="text-[11px] tracking-wide italic bg-red-600/0 text-default-500">{{ $assistiveText }}</p>
            @endif
        </div>
        <output id="result-{{ $name }}"
                class="absolute
                       px-2 py-0.5 rounded-full
                       flex justify-center items-center
                       text-[11px] font-semibold tracking-wide
                       bg-default-800/15 text-default-800">
            {{ $value }}
        </output>
    </div>

    @php $percentage = (($value - $min) * 100) / ($max - $min); @endphp

    <input type="range"
           name="{{ $name }}"
           id="{{ $name }}"
           @if($value) value="{{ $value }}" @endif
           @if($title) title="{{ $title }}" @endif

           @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
           @if($autofocus) autofocus @endif
           @if($disabled || $readonly) disabled @endif
           @if($required) required @endif

           @if($min) min="{{ $min }}" @endif
           @if($max) max="{{ $max }}" @endif
           @if($step) step="{{ $step }}" @endif

           @php
               $colorBg =  [
                             'default' => 'color-mix(in oklab, var(--color-default-200) 70%, transparent)',
                             'hover' => 'var(--color-default-200)',
                           ];
               $colorFill =  [
                               'default' => 'var(--color-default-400)',
                               'focus' => 'var(--color-primary)',
                             ];
               $colorError =  [
                                'default' => "color-mix(in oklab, var(--color-error) 50%, {$colorFill['default']})",
                                'focus' => 'var(--color-error)',
                              ];
           @endphp

           style="--range-bg: {{ $colorBg['default'] }};
                  --range-fill: {{ $error ? $colorError['default'] : $colorFill['default'] }};
                  background: linear-gradient(to right, var(--range-fill) {{ $percentage }}%, var(--range-bg) {{ $percentage }}%);"

           class="appearance-none
                  w-full h-3 rounded-lg
                  @if(!$readonly) disabled:opacity-50 @endif disabled:pointer-events-none
                  focus:outline-none

                  [&::-webkit-slider-thumb]:appearance-none
                  [&::-webkit-slider-thumb]:w-5
                  [&::-webkit-slider-thumb]:h-4
                  [&::-webkit-slider-thumb]:rounded-full
                  [&::-webkit-slider-thumb]:bg-white
                  [&::-webkit-slider-thumb]:border-4
                  [&::-webkit-slider-thumb]:border-(--range-fill)
                  [&::-webkit-slider-thumb]:shadow-center
                  [&::-webkit-slider-thumb]:transition-colors
                  [&::-webkit-slider-thumb]:duration-200
                  [&::-webkit-slider-thumb]:cursor-pointer

                  [&::-webkit-slider-runnable-track]:cursor-pointer"

           oninput="updateRange(this);"

           onmouseout="this.style.setProperty('--range-bg', '{{ $colorBg['default'] }}')"
           onmouseover="this.style.setProperty('--range-bg', '{{ $colorBg['hover'] }}')"

           onblur="this.style.setProperty('--range-fill', '{{ $error ? $colorError['default'] : $colorFill['default'] }}')"
           onfocus="this.style.setProperty('--range-fill', '{{ $error ?$colorError['focus'] : $colorFill['focus'] }}')"

           @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach
    />

    @once
        @push('scripts')
            <script>
                function updateRange(range) {
                    const name = range.name;
                    const val = range.value;
                    const min = range.min;
                    const max = range.max;
                    const percent = ((val - min) * 100) / (max - min);

                    range.style.background = `linear-gradient(to right, var(--range-fill) ${percent}%, var(--range-bg) ${percent}%)`;

                    const output = document.getElementById(`result-${name}`);
                    output.value = val;

                    const container = document.getElementById(`${name}-container`);
                    const label = container.querySelector('.label-container');
                    const margin = (percent / 100 * (container.offsetWidth - output.offsetWidth));
                    output.style.marginLeft = `${Math.max(margin, label.offsetWidth)}px`;

                    if (range.disabled && !range.dataset.readonly)
                        output.classList.add('hidden');
                    else output.classList.remove('hidden');
                }

                document.addEventListener('DOMContentLoaded', () =>
                    document.querySelectorAll('input[type="range"]').forEach(range => updateRange(range)));
            </script>
        @endpush
    @endonce

</div>
