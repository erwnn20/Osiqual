@props([
    'name',
    'label' => null,
    'assistiveText' => null,
    'error' => null,
    'title' => null,
    'data' => [],

    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,

    'multiple' => false,
    'accept' => null,
    'webkitdirectory' => false,
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

    <input type="file"
           name="{{ $name }}"
           id="{{ $name }}"
           @if($title) title="{{ $title }}" @endif

           @if($autofocus) autofocus @endif
           @if($disabled || $readonly) disabled @endif
           @if($required) required @endif

           @if($multiple) multiple @endif
           @if($accept) accept="{{ $accept }}" @endif
           @if($webkitdirectory) webkitdirectory @endif

           class="w-full rounded-lg file:py-2.5 file:px-3 file:me-4
                  bg-default-200/70 file:bg-default-300/35
                  text-default-800 text-sm file:font-semibold

                  ring-2 ring-offset-0 ring-offset-default-50
                  @if($error)
                    ring-error/50 focus:ring-error focus:file:bg-error/80
                  @else
                    ring-transparent focus:ring-primary focus:file:bg-primary/80
                  @endif

                  transition-all duration-200 cursor-pointer file:cursor-pointer
                  file:transition-all file:duration-200

                  @if(!$readonly) disabled:opacity-50 @endif disabled:pointer-events-none
                  hover:bg-default-200
                  focus:outline-none focus:file:text-slate-100"

           @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach
    />

    @if($error)
        <div class="flex items-center gap-1 mt-0.5">
            <i class="h-4 w-fit text-error" data-lucide="circle-alert"></i>
            <p class="text-xs tracking-wide italic text-error">{{ $error }}</p>
        </div>
    @elseif($assistiveText)
        <p class="text-xs tracking-wide italic text-default-500">{{ $assistiveText }}</p>
    @endif

</div>
