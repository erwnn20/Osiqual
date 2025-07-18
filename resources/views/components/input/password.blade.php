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

    'minlength' => null,
    'maxlength' => null,
    'pattern' => null,
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
        <input type="password"
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

               class="w-full rounded-lg py-2 px-3 pe-10
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

        <div class="absolute inset-y-0 me-3 my-auto flex items-center h-fit right-0">
            <button
                type="button"
                class="text-default-800 transition-colors duration-200
                       hover:cursor-pointer hover:text-default-800/50"
                onclick="togglePassword('{{ $name }}', this)"
                tabindex="-1"
            >
                <i class="h-5 w-5" data-lucide="eye"></i>
                <i class="h-5 w-5 hidden" data-lucide="eye-closed"></i>
            </button>
        </div>

        @once
            @push('scripts')
                <script>
                    function togglePassword(inputId, btn) {
                        const input = document.getElementById(inputId);
                        const iconOpen = btn.querySelector('[data-lucide="eye"]');
                        const iconClosed = btn.querySelector('[data-lucide="eye-closed"]');

                        if (input.type === 'password') {
                            input.type = 'text';
                            iconOpen.classList.add('hidden');
                            iconClosed.classList.remove('hidden');
                        } else {
                            input.type = 'password';
                            iconClosed.classList.add('hidden');
                            iconOpen.classList.remove('hidden');
                        }
                    }
                </script>
            @endpush
        @endonce
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
