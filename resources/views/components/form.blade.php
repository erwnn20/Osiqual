@props([
    'action' => null,
    'method',

    'gap' => 'gap-8',
])

<form @if(!empty($action)) action="{{ $action }}" @endif method="post"
      {{ $attributes->class(['flex', 'flex-col', $gap]) }}>
    @csrf
    @method($method)

    {{ $slot }}

</form>
