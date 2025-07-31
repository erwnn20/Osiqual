@props([
    'icon' => null,
    'size' => 'sm',
    'color' => 'primary',

    'href' => null,
    'form' => null,
    'data' => [],

    'title' => null,
    'autofocus' => false,
    'disabled' => false,
])

@php $tag = $href && !$disabled ? 'a' : 'button' ; /* is a link */ @endphp

<{{ $tag }}
    {{ $attributes->class(['btn', "btn-$size", 'btn-icon' => !empty($icon), "btn-$color"]) }}

    @if($href) href="{{ $href }}" @endif
    @if($form) form="{{ $form }}" @endif
    @if($title) title="{{ $title }}" @endif
    @if($autofocus) autofocus @endif
    @if($disabled) disabled @endif

    @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach
>
    @if($icon)
        <i class="w-fit stroke-3" data-lucide="{{ $icon }}"></i>
    @endif
    {{ $slot }}
</{{ $tag }}>
