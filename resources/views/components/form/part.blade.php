@props([
    'title' => '',
    'submit' => null,
    'buttons' => [],
])

<div {{ $attributes->class(['flex', 'flex-col', 'gap-3']) }}>
    <div class="flex items-baseline">
        @if($title)
            <h3 class="text-2xl/tight font-bold">{{ $title }}</h3>
        @endif

        <div class="flex gap-2.5 items-center ms-auto">
            {{-- buttons array structure :
                [
                    [
                        'type' => '...',
                        'text' => '...',
                        'icon' => '...', // see button component, optional
                        'size' => '...', // see button component, optional
                        'color' => '...', // see button component, optional
                        'form' => '...', // form to which the button is assigned, optional
                        'class' => '...', // additional classes, optional
                        'active' => bool, // define if the button as to be shown
                    ],
                    ...
                ]
            --}}

            @foreach($buttons as $button)
                @if($button['active'] ?? true)
                    <x-button :type="$button['type']"
                              :icon="$button['icon'] ?? null"
                              :size="$button['size'] ?? null"
                              :color="$button['color'] ?? null"
                              :form="$button['form'] ?? null"
                              :class="$button['class'] ?? ''">
                        {{ $button['text'] }}
                    </x-button>
                @endif
            @endforeach

            @if($submit)
                <x-button type="submit" :icon="$submit['icon'] ?? null" size="md">
                    {{ $submit['text'] }}
                </x-button>
            @endif
        </div>
    </div>

    <div class="p-5 flex flex-col gap-4
                bg-default-50 shadow-lg rounded-xl">

        {{ $slot }}

    </div>

</div>
