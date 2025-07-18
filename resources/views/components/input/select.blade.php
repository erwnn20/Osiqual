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

    'multiple' => false,
    'size' => null,
    'options' => [],
])

{{-- example of options structure :
    'options' => [
                   ['type' => 'option', 'value' => 'opt-default', 'label' => 'Default'],
                   ['type' => 'opt', 'value' => 'opt-no-label'],  // 'label' will have the value of 'value'
                   ['value' => 'opt-no-type-label'],  // default type => 'option'
                   [
                     'type' => 'group',
                     'label' => 'Group Name',
                     'value' => [
                       ['value' => 'group-opt-1'], // option -> structure of default option
                       ['value' => 'group-opt-2'],
                      ],
                   ],
                   [
                     'type' => 'optgroup',
                     'label' => 'Group Name',
                     'value' => [
                       ['value' => 'optgroup-opt-1'],
                       ['value' => 'optgroup-opt-2'],
                      ],
                   ],
                ]
--}}

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
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            @if($title) title="{{ $title }}" @endif

            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if($autofocus) autofocus @endif
            @if($disabled || $readonly) disabled @endif
            @if($required) required @endif

            @if($multiple) multiple @endif
            @if($size) size="{{ $size }}" @endif

            class="appearance-none
                   w-full rounded-lg py-2 px-3 pe-10
                  bg-default-200/70 text-default-800

                  ring-2 ring-offset-0 ring-offset-default-50
                  @if($error) ring-error/50 focus:ring-error
                  @else ring-transparent focus:ring-primary @endif

                  transition-all duration-200 cursor-pointer

                  @if($disabled) disabled:opacity-50 @endif disabled:pointer-events-none
                  hover:bg-default-200
                  focus:outline-none"

            @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach
        >
            @if($placeholder)
                <x-input.select.option
                    value=""
                    :selected="empty($value)"
                    :label="$placeholder"
                    class="text-default-400/80 italic"
                />
            @endif

            @foreach($options as $option)
                @isset($option['type'])
                    @switch($option['type'])

                        @case('group')
                        @case('optgroup')
                            <optgroup label="{{ $option['label'] }}">
                                @foreach($option['value'] as $opt)
                                    <x-input.select.option
                                        :value="$opt['value']"
                                        :selected="$value === $opt['value']"
                                        :label="$opt['label'] ?? null"
                                        :data="$option['data'] ?? []"
                                    />
                                @endforeach
                            </optgroup>
                            @break

                        @case('opt')
                        @case('option')
                        @default
                            <x-input.select.option
                                :value="$option['value']"
                                :selected="$value === $option['value']"
                                :label="$option['label'] ?? null"
                                :data="$option['data'] ?? []"
                            />
                            @break

                    @endswitch
                @else
                    <x-input.select.option
                        :value="$option['value']"
                        :selected="$value === $option['value']"
                        :label="$option['label'] ?? null"
                        :data="$option['data'] ?? []"
                    />
                @endisset
            @endforeach
        </select>

        @if(!$disabled && !$readonly && !$multiple)
            <div class="absolute inset-y-0 right-0 mx-3 my-auto
                        flex items-center h-fit pointer-events-none">
                <i class="h-5 w-5 text-primary" data-lucide="chevron-down"></i>
            </div>
        @endif
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
