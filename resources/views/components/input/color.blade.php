@props([
    'name',
    'label' => null,
    'value' => null,
    'assistiveText' => null,
    'error' => null,
    'title' => null,
    'data' => [],

    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,

    'labelPosition' => 'right', /* other options: top */
])

<div id="{{ $name .'-container' }}"
         {{ $attributes->class(['flex', 'gap-1',
                                'flex-col' => $labelPosition === 'top',
                                'items-center' => $labelPosition === 'right']) }}>

    @if($labelPosition === 'top' && ($label || $required))
        <label for="{{ $name }}" class="w-fit text-sm font-medium text-default-700">
            {{ $label }}
            @if($required)
                <span id="{{ $name }}-required" class="font-normal text-error">*</span>
            @endif
        </label>
    @endif

    <input type="color"
           name="{{ $name }}"
           id="{{ $name }}"
           @if($value) value="{{ $value }}" @endif
           @if($title) title="{{ $title }}" @endif

           @if($autofocus) autofocus @endif
           @if($disabled || $readonly) disabled @endif
           @if($required) required @endif

           class="h-8 w-full min-w-12 rounded-lg m-1

                  ring-2 ring-offset-2 ring-offset-default-50
                  @if($error) ring-error/50 focus:ring-error
                  @else ring-default-300 focus:ring-primary @endif

                  transition-all duration-200 cursor-pointer
                  @if($disabled) disabled:opacity-65 @endif disabled:pointer-events-none
                  focus:outline-none

                  [&::-webkit-color-swatch-wrapper]:p-0
                  [&::-webkit-color-swatch]:border-none"

           @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach
    />

    <div @class(['flex', 'flex-col', 'justify-center-center', 'ms-1' => $labelPosition === 'right'])>
        @if($labelPosition === 'right')
            @if($label || $required)
                <label for="{{ $name }}" class="text-sm/snug font-medium text-default-700 whitespace-nowrap">
                    {{ $label }}
                    @if($required)
                        <span id="{{ $name }}-required" class="font-normal text-error">*</span>
                    @endif
                </label>
            @endif
        @endif

        @if($error)
            <div class="flex items-center gap-1">
                <i class="h-4 w-fit text-error" data-lucide="circle-alert"></i>
                <p class="text-xs/tight tracking-wide italic text-error whitespace-nowrap">{{ $error }}</p>
            </div>
        @elseif($assistiveText)
            <p class="text-xs/tight tracking-wide italic text-default-500 whitespace-nowrap">{{ $assistiveText }}</p>
        @endif
    </div>

</div>
