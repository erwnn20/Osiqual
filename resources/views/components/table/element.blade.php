@props([
    'head' => false
])

<{{ $head ? 'th scope="row"' : 'td' }} {{ $attributes }}>

    {{ $slot }}

</{{ $head ? 'th' : 'td' }}>
