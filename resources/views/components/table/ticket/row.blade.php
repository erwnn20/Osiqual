@props([
    'data',
    'edit' => false,
])

<tr class="bg-default-50 border-b border-default-200 hover:bg-default-100">
    <!-- Title -->
    <x-table.element :head="true" class="ps-6">{{ $data->title }}</x-table.element>

    <!-- Client -->
    <x-table.element.user :user="$data->client" :company="true"/>

    <!-- Tech -->
    <x-table.element.user :user="$data->technician"/>

    <!-- Duration -->
    <x-table.element.duration :duration="$data->duration"/>

    <!-- Status -->
    <x-table.element.label :color="$data->status->color">
        {{ $data->status->name }}
    </x-table.element.label>

    <!-- Priority -->
    <x-table.element.label :color="$data->priority->color">
        {{ $data->priority->name }}
    </x-table.element.label>

    <!-- Criticality -->
    <x-table.element.label :color="$data->criticality->color">
        {{ $data->criticality->name }}
    </x-table.element.label>

    <!-- Creation Date -->
    <x-table.element.date :date="$data->creation_date"/>

    <!-- End Date -->
    <x-table.element.date :date="$data->end_date"/>

    <!-- Actions -->
    <td class="flex items-center gap-1">
        @if($edit)
            <x-button :href="route('ticket.edit', ['id' => $data->id])" size="sm" color="link">Modifier</x-button>
        @else
            <x-button :href="route('ticket.view', ['id' => $data->id])" size="sm" color="link">Voir</x-button>
        @endif
    </td>
</tr>
