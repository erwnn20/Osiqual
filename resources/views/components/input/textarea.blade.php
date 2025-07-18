@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'assistiveText' => null,
    'error' => null,
    'title' => null,
    'data' => [],

    'autocomplete' => null,
    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,

    'spellcheck' => true,
    'minlength' => null,
    'maxlength' => null,
    'wrap' => null,
])

<div id="{{ $name .'-container' }}" {{ $attributes->class(['flex', 'flex-col', 'gap-1']) }}>

    <div @class(['flex', 'gap-2.5', 'items-baseline' => !$error , 'items-center' => $error])>
        @if($label || $required)
            <label for="{{ $name }}" class="w-fit text-sm font-medium text-default-700">
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
            <p class="text-[11px] tracking-wide italic text-default-500">{{ $assistiveText }}</p>
        @endif
    </div>

    <textarea
           name="{{ $name }}"
           id="{{ $name }}"
           @if($placeholder) placeholder="{{ $placeholder }}" @endif
           @if($title) title="{{ $title }}" @endif

           @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
           @if($autofocus) autofocus @endif
           @if($disabled) disabled @endif
           @if($readonly) readonly @endif
           @if($required) required @endif

           spellcheck="{{ $spellcheck ? 'true' : 'false' }}"
           @if($minlength) minlength="{{ $minlength }}" @endif
           @if($maxlength) maxlength="{{ $maxlength }}" @endif
           @if($wrap) wrap="{{ $wrap }}" @endif

           class="min-h-24 max-h-48 w-full h-full rounded-lg py-2 px-3
                      bg-default-200/70 text-default-800
                      placeholder-default-400/80

                      ring-2 ring-offset-0 ring-offset-default-50
                      @if($error) ring-error/50 focus:ring-error
                      @else ring-transparent focus:ring-primary @endif

                      transition-shadow duration-200 cursor-text

                      read-only:pointer-events-none
                      disabled:opacity-50 disabled:pointer-events-none
                      hover:bg-default-200
                      focus:outline-none"

           @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach
    >{{ $value }}</textarea>

</div>
