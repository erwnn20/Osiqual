@props([
    'name',
    'label' => null,
    'value',
    'assistiveText' => null,
    'error' => null,
    'title' => null,
    'data' => [],

    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,

    'checked' => false,
])

<label id="{{ $name .'-container' }}"
       for="{{ $name }}"
    {{ $attributes->class(['flex', 'gap-2', 'items-center', 'relative', 'w-fit']) }}>

    <input type="checkbox"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ $value }}"
           @if($title) title="{{ $title }}" @endif

           @if($autofocus) autofocus @endif
           @if($disabled || $readonly) disabled @endif
           @if($required) required @endif

           @if($checked) checked @endif

           class="appearance-none peer
                  w-4 h-4 rounded-sm bg-default-200/70

                  ring-2 ring-offset-2 ring-offset-default-50
                  @if($error) ring-error/50 focus:ring-error
                  @else ring-transparent focus:ring-primary @endif

                  transition-all duration-200 cursor-pointer

                  @if($disabled) disabled:opacity-50 @endif disabled:pointer-events-none
                  hover:bg-default-200
                  focus:outline-none"

           @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach
    />

    <span class="absolute
                 w-4 h-4 rounded-sm p-0.5
                 bg-primary peer-hover:bg-primary/80 peer-active:bg-primary/70
                 opacity-0 peer-checked:opacity-100 @if($disabled) peer-disabled:opacity-50 @endif
                 transition-all duration-200 pointer-events-none">
        <i class="h-full w-full text-white stroke-3" data-lucide="check"></i>
    </span>

    <div @class(['flex', 'gap-1.5', 'items-baseline' => !$error , 'items-center' => $error])>
        @if($label || $required)
            <p class="text-sm font-medium text-default-700">
                {{ $label }}
                @if($required)
                    <span id="{{ $name }}-required" class="font-normal text-error">*</span>
                @endif
            </p>
        @endif
        @if($error)
            <div class="flex items-center gap-1 h-full">
                <i class="h-3.5 w-fit text-red-600" data-lucide="circle-alert"></i>
                <p class="text-[11px] tracking-wide italic text-red-600">{{ $error }}</p>
            </div>
        @elseif($assistiveText)
            <p class="text-[11px] tracking-wide italic text-default-500">{{ $assistiveText }}</p>
        @endif
    </div>

</label>
