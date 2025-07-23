@php use Illuminate\Support\Number; @endphp
@props([
    'contract' => null,
    'title' => 'Consommation du Contrat',
    'error' => 'Aucun Contrat',
])

<div>

    <div class="mb-2">
        @if($contract)
            {{ $slot }}
        @else
            <h3 class="text-xl/tight font-semibold italic">{{ $error }}</h3>
        @endif
    </div>

    @php
        if ($contract){
            if ($contract->type->monthly) {
                $today = now();
                $compare = $contract->end_date->min($today);

                $diffUsed = $contract->start_date->diff($compare);
                $diffRemaining = $contract->end_date->diff($compare);

                $maxDays = $contract->start_date->diffInDays($contract->end_date);
                $usedDays = $contract->start_date->diffInDays($compare);
                $remainingDays = $contract->end_date->diffInDays($compare);

                $max = [
                    'value' => $maxDays,
                    'detail' => $contract->end_date->format('d/m/Y'),
                    'compact' => $contract->end_date->translatedFormat('F Y'),
                ];
                $used = [
                    'value' => $usedDays,
                    'detail' => (int) ceil(abs($usedDays)) . ' jours',
                    'compact' => ($contract->start_date > $today ? 'Commence dans ' : '') .
                                 (int) ceil($contract->start_date->diffInMonths($compare, true)) . ' mois',
                ];
                $remaining = [
                    'value' => $diffRemaining,
                    'detail' => (int) ceil(abs($remainingDays)) . ' jours',
                    'compact' => (int) ceil($contract->end_date->diffInMonths($compare, true)) . ' mois',
                    'condition' => ($diffRemaining->y * 12 + $diffRemaining->m) > 1,
                ];
            } else {
                $used = [
                    'value' => $value = $contract->durationUsed(),
                    'detail' => "$value min",
                    'compact' => round($value / 60, 1) . ' h',
                ];
                $remaining = [
                    'value' => $value = $contract->durationRemaining(),
                    'detail' => "$value min",
                    'compact' => round($value / 60, 1) . ' h',
                    'condition' => $value > 60,
                ];
                $max = [
                    'value' => $value = $contract->type->duration,
                    'detail' => "$value min",
                    'compact' => round($value / 60, 1) . ' h',
                ];
            }

            $percentage = Number::clamp(($used['value'] / $max['value']) * 100, min: 0, max: 100);
        } else
            $percentage = 100;
    @endphp

    <div class="w-full min-w-40 h-4 rounded-full bg-default-300">
        <div class="h-full @if($percentage < 95) bg-primary @else bg-error @endif rounded-full"
             style="width: {{ $percentage }}%;"></div>
    </div>

    @if($contract)
        <div class="relative w-full flex mt-1 text-sm italic">
            @if($percentage > 12)
                <span class="absolute">
                    Restant: {{ $remaining['condition'] ? $remaining['compact'] : $remaining['detail'] }} ({{ 100-round($percentage, 1) }}%)
                </span>
            @endif

            <span style="padding-inline-start: {{ $percentage-2 }}%;">
                {{ $used['compact'] }}
            </span>

            @if($percentage < 98)
                <span class="ms-auto">{{ $max['compact'] }}</span>
            @endif
        </div>
    @endif
</div>
