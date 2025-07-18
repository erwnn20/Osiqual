@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => '+33 6 12 34 56 78',
    'assistiveText' => null,
    'error' => null,
    'title' => null,
    'data' => [],

    'autocomplete' => null,
    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,

    'minlength' => null,
    'maxlength' => null,
    'pattern' => '^(\+33|0)[1-9]([-. ]?\d{2}){4}$',
    'size' => null,
])

<div id="{{ $name .'-container' }}" {{ $attributes->class(['flex', 'flex-col', 'gap-1']) }}>

    @if($label || $required)
        <label for="{{ $name }}" class="w-fit text-sm font-medium text-default-700">
            {{ $label }}
            @if($required)
                <span id="{{ $name }}-required" class="font-normal text-error">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <div class="absolute inset-y-0 mx-3 my-auto
                    flex items-center h-fit pointer-events-none">
            <i class="h-5 w-fit text-default-500" data-lucide="phone"></i>
        </div>

        <input type="tel"
               name="{{ $name }}"
               id="{{ $name }}"
               @if($value) value="{{ $value }}" @endif
               @if($placeholder) placeholder="{{ $placeholder }}" @endif
               @if($title) title="{{ $title }}" @endif

               @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
               @if($autofocus) autofocus @endif
               @if($disabled) disabled @endif
               @if($readonly) readonly @endif
               @if($required) required @endif

               @if($minlength) minlength="{{ $minlength }}" @endif
               @if($maxlength) maxlength="{{ $maxlength }}" @endif
               @if($pattern) pattern="{{ $pattern }}" @endif
               @if($size) size="{{ $size }}" @endif

               class="w-full rounded-lg py-2 px-3 ps-10
                      bg-default-200/70 text-default-800
                      placeholder-default-400/80

                      ring-2 ring-offset-0 ring-offset-default-50
                      @if($error) ring-error/50 focus:ring-error
                      @else ring-transparent focus:ring-primary @endif

                      transition-all duration-200 cursor-text

                      read-only:pointer-events-none
                      disabled:opacity-50 disabled:pointer-events-none
                      hover:bg-default-200
                      focus:outline-none"

               @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach
        />
    </div>

    @if($error)
        <div class="flex items-center gap-1 mt-0.5">
            <i class="h-4 w-fit text-error" data-lucide="circle-alert"></i>
            <p class="text-xs tracking-wide italic text-error">{{ $error }}</p>
        </div>
    @elseif($assistiveText)
        <p class="text-xs tracking-wide italic text-default-500">{{ $assistiveText }}</p>
    @endif

</div>
