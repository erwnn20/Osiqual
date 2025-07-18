@props([
    'head' => false,

    'duration',
])

<x-table.element :head="$head" {{ $attributes }}>
    @if(is_array($duration))
        @php $used = $duration['used'] @endphp
        @php $remaining = $duration['remaining'] @endphp
        @php $max = $duration['max'] @endphp

        @php $percentage = ($used  / $max) * 100  @endphp

        <div class="w-full flex justify-between mb-1">
            <span class="text-xs italic" style="padding-inline-start: {{ $percentage-10 }}%;">
                {{ round($used / 60, 1) }} h
            </span>

            @if($percentage < 82.5)
                <span class="text-xs italic">{{ round($max / 60, 1) }} h</span>
            @endif
        </div>

        <div class="w-full min-w-40 h-2.5 rounded-full bg-default-300">
            <div class="h-full @if($percentage < 95) bg-primary @else bg-error @endif rounded-full" style="width: {{ $percentage }}%;"></div>
        </div>

        <span class="mt-1 ms-auto text-[11px] italic">
            Restant: {{ $remaining > 60 ? round($remaining / 60, 1) . ' h' : "$remaining min" }} ({{ 100-round($percentage, 1) }}%)
        </span>
    @else
        {{ $duration >= 60 ? floor($duration / 60) . ' h' . ($duration % 60 > 0 ? ' ' . $duration % 60 . ' min' : '') : $duration . ' min' }}
    @endif
</x-table.element>
