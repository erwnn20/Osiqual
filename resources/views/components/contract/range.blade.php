@props([
    'contract' => null,
    'title' => 'Consommation du Contrat',
    'error' => 'Aucun Contrat',
])

@if($contract)

    <div>
        @php $used = $contract->durationUsed() @endphp
        @php $remaining = $contract->durationRemaining() @endphp
        @php $max = $contract->type->duration @endphp

        @php $percentage = ($used  / $max) * 100  @endphp

        <div class="flex items-baseline gap-3.5 mb-2">
            <h3 class="text-2xl/tight font-bold">{{ $title }}</h3>
            <h5 class="text-lg font-semibold">Contrat {{ $contract->type->monthly ? 'Mensuel' : 'Fixe' }}</h5>
        </div>

        <div class="w-full min-w-40 h-4 rounded-full bg-default-300">
            <div class="h-full @if($percentage < 95) bg-primary @else bg-error @endif rounded-full" style="width: {{ $percentage }}%;"></div>
        </div>

        <div class="relative w-full flex mt-1 text-sm italic">
            @if($percentage > 12)
                <span class="absolute">
                    Restant: {{ $remaining > 60 ? round($remaining / 60, 1) . ' h' : "$remaining min" }} ({{ 100-round($percentage, 1) }}%)
                </span>
            @endif

            <span style="padding-inline-start: {{ $percentage-2 }}%;">
                {{ round($used / 60, 1) }} h
            </span>

            @if($percentage < 98)
                <span class="ms-auto">{{ round($max / 60, 1) }} h</span>
            @endif
        </div>
    </div>

@else

    <div>
        <div class="flex items-baseline gap-3.5 mb-2">
            <h3 class="text-xl/tight font-semibold italic">{{ $error }}</h3>
        </div>

        <div class="w-full min-w-40 h-4 rounded-full bg-error"></div>
    </div>

@endif



