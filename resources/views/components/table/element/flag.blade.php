@php use Illuminate\Support\Str; @endphp

@props([
    'head' => false,

    'countryIso',
])

@php
    $country = country($countryIso);
    $translations = $country->getTranslations();
@endphp

<x-table.element :head="$head" {{ $attributes->class(['flex', 'items-center', 'gap-2']) }}>
    <div class="w-7 flex justify-center items-center">
        <img
            class="max-w-7 max-h-5 rounded shrink-0"
            src="https://flagcdn.com/{{ Str::lower($countryIso) }}.svg"
            alt="{{ $translations['eng']['common'] }}">
    </div>

    <span>{{ ($translations['fra'] ?? $translations['eng'])['common'] }}</span>
</x-table.element>
