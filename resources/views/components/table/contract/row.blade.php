@props([
    'data',
    'edit' => false,
])

<tr class="bg-default-50 border-b border-default-200 hover:bg-default-100">
    <!-- Company -->
    <x-table.element :head="true" class="ps-6">
        <div class="flex gap-1.5 items-center">
            {{ $data->company->name }}

            @if($data->isParent())
                <div title="Contrat parent">
                    <i class="h-4 w-fit text-default-400/65 filled" data-lucide="star"></i>
                </div>
            @endif
        </div>
    </x-table.element>

    <!-- Type -->
    <x-table.element>{{ $data->type->name }}</x-table.element>

    <!-- Duration -->
    @if($data->type->monthly)
        @php
            $today = now();
            $compare = $data->end_date->min($today);

            $diffUsed = $data->start_date->diff($compare);
            $diffRemaining = $data->end_date->diff($compare);

            $maxDays = $data->start_date->diffInDays($data->end_date);
            $usedDays = $data->start_date->diffInDays($compare);
            $remainingDays = $data->end_date->diffInDays($compare);

            $used = [
                'value' => $usedDays,
                'detail' => (int) ceil(abs($usedDays)) . ' jours',
                'condition' => $condition = $data->start_date < $today,
                'compact' => !$condition ? $data->start_date->translatedFormat('F Y')
                                         : ((int) ceil($data->start_date->diffInMonths($compare, true)) . ' mois'),
                'message' => 'Commence dans ' . (int) ceil($data->start_date->diffInMonths($compare, true)) . ' mois'
            ];
            $remaining = [
                'value' => $diffRemaining,
                'diff' => $remainingDays,
                'detail' => (int) ceil(abs($remainingDays)) . ' jours',
                'compact' => (int) ceil($data->end_date->diffInMonths($compare, true)) . ' mois',
                'condition' => ($diffRemaining->y * 12 + $diffRemaining->m) > 1,
            ];
            $max = [
                'value' => $maxDays,
                'detail' => $data->end_date->format('d/m/Y'),
                'compact' => $data->end_date->translatedFormat('F Y'),
            ];
        @endphp
    @else
        @php
            $used = [
                'value' => $value = $data->durationUsed(),
                'detail' => "$value min",
                'condition' => true,
                'compact' => round($value / 60, 1) . ' h',
            ];
            $remaining = [
                'value' => $value = $data->durationRemaining(),
                'detail' => "$value min",
                'compact' => round($value / 60, 1) . ' h',
                'condition' => $value > 60,
            ];
            $max = [
                'value' => $value = $data->type->duration,
                'detail' => "$value min",
                'compact' => round($value / 60, 1) . ' h',
            ];
        @endphp
    @endif
    <x-table.element.duration
            :duration="['used' => $used, 'remaining' => $remaining, 'max' => $max]"
    />

    <!-- Status -->
    <x-table.element.label :color="$data->status->color">
        {{ $data->status->name }}
    </x-table.element.label>

    <!-- Creation Date -->
    <x-table.element.date :date="$data->start_date"/>

    <!-- End Date -->
    <x-table.element.date :date="$data->end_date"/>

    <!-- Actions -->
    <td class="flex items-center gap-1">
        <x-button :href="route('contract.view', ['id' => $data->id])" size="sm" color="link">Voir</x-button>
    </td>
</tr>
