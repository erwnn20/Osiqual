@props([
    'data',
    'edit' => false,
])

<tr class="bg-default-50 border-b border-default-200 hover:bg-default-100">
    <!-- Name -->
    <x-table.element :head="true" class="ps-6">
        <div class="flex gap-1 items-center">
            {{ $data->name }}

            @if(!$data->currentContracts('attributable')->count() > 0)
                <x-tooltip title="Aucun Contrat pouvant accueillir de Ticket en Cours">
                    <i class="h-4 w-fit text-error" data-lucide="circle-alert"></i>
                </x-tooltip>
            @endif
        </div>
    </x-table.element>

    <!-- Address -->
    <x-table.element>{{ $data->address }}, {{ $data->zipcode }}</x-table.element>

    <!-- City -->
    <x-table.element>{{ $data->city }}</x-table.element>

    <!-- Country -->
    <x-table.element.flag :countryIso="$data->country"/>

    <!-- SIRET -->
    <x-table.element>
        {{ $data->siret }}
    </x-table.element>

    <!-- Actions -->
    <td class="flex items-center gap-1">
        @if($edit)
            <x-button :href="route('company.edit', ['id' => $data->id])" size="sm" color="link">Modifier</x-button>
        @else
            <x-button :href="route('company.view', ['id' => $data->id])" size="sm" color="link">Voir</x-button>
        @endif
    </td>
</tr>
