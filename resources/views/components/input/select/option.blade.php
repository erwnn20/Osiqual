@props([
    'value',
    'selected' => false,
    'label' => $label ?? $value,

    'data' => [],
])

<option value="{{ $value }}"
        @if($selected) selected @endif

        @foreach($data as $k => $v) data-{{$k}}="{{$v}}" @endforeach

        {{ $attributes }}
>
    {{ $label }}
</option>
