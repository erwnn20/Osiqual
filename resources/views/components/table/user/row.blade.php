@props([
    'data',
    'edit' => false,
])

<tr class="bg-default-50 border-b border-default-200 hover:bg-default-100">
    <!-- User -->
    <x-table.element.user :head="true" class="ps-6" :user="$data" :company="true" :link="false"/>

    <!-- Role -->
    <x-table.element class="font-semibold">{{ $data->role->name }}</x-table.element>

    <!-- Login -->
    <x-table.element class="italic">{{ $data->login }}</x-table.element>

    <!-- Email -->
    <x-table.element class="text-primary">{{ $data->email }}</x-table.element>

    <!-- Phone -->
    <x-table.element>{{ $data->phone }}</x-table.element>

    <!-- Active -->
    <x-table.element.label :color="$data->active ? '#00B112' : '#DA3636'">
        {{ $data->active ? 'Actif' : 'Bloqué' }}
    </x-table.element.label>

    <!-- Actions -->
    <td class="flex items-center justify-end gap-1">
        @if($edit && !$data->role->permission_admin)
            @if($data->active)
                <x-form :action="route('user.block', ['id' => $data->id])" method="patch">
                    <x-button type="submit" size="sm" color="link" icon="ban" class="negative">Bloquer</x-button>
                </x-form>
            @else
                <x-form :action="route('user.unblock', ['id' => $data->id])" method="patch">
                    <x-button size="sm" color="link" icon="check" class="positive">Débloquer</x-button>
                </x-form>
            @endif
            <x-button :href="route('user.edit', ['id' => $data->id])" size="sm" color="link">Modifier</x-button>
        @else
            <x-button :href="route('user.view', ['id' => $data->id])" size="sm" color="link">Voir</x-button>
        @endif
    </td>
</tr>
