@props([
    'data',
    'edit' => false,
])

<tr class="bg-default-50 border-b border-default-200 hover:bg-default-100">
    <!-- Company -->
    <x-table.element :head="true" class="ps-6">
        <div class="flex gap-1 items-center">
            {{ $data->company->name }}

            @if($data->isParent())
                <x-tooltip title="Contrat parent">
                    <i class="h-4 w-fit text-default-400/65 filled" data-lucide="star"></i>
                </x-tooltip>
            @endif
        </div>
    </x-table.element>

    <!-- Type -->
    <x-table.element>{{ $data->type->name }}</x-table.element>

    <!-- Duration -->
    <x-table.element.duration
        :duration="['used' => $data->durationUsed(), 'remaining' => $data->durationRemaining(), 'max' => $data->type->duration]"/>

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
        @if($edit)
            <x-button :href="route('contract.edit', ['id' => $data->id])" size="sm" color="link">Modifier
            </x-button>
        @else
            <x-button :href="route('contract.view', ['id' => $data->id])" size="sm" color="link">Voir</x-button>
        @endif
    </td>
</tr>
