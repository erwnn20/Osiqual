@php use App\Models\User;use Carbon\Carbon;use Illuminate\Support\Facades\Route;use Illuminate\Support\Str;use App\Models\Ticket;use App\Models\Contract; @endphp
@props([
    'data',
    'edit' => false,
])

<tr class="bg-default-50 border-b border-default-200 hover:bg-default-100">
    <!-- Name -->
    <x-table.element :head="true" class="ps-6">{{ $data->name }}</x-table.element>

    <!-- Number of appearances -->
    @php
        $number = match (get_class($data)) {
            Ticket\TicketStatus::class =>
                Ticket::where('status_id', $data->id)->count(),

            Ticket\TicketPriority::class =>
                Ticket::where('priority_id', $data->id)->count(),

            Ticket\TicketCriticality::class =>
                Ticket::where('criticality_id', $data->id)->count(),

            Contract\ContractStatus::class =>
                Contract::all()->filter(fn($contract) => $contract->status->id === $data->id)->count(),

            Contract\ContractType::class =>
                Contract::where('type_id', $data->id)->count(),

            User\Role::class =>
                User::where('role_id', $data->id)->count(),

            default => 0,
        };
    @endphp
    <x-table.element.label color="#808080" class="flex items-center justify-end">
        {{ $number }}
    </x-table.element.label>

    @switch(get_class($data))

        @case(Ticket\TicketCriticality::class)
        @case(Ticket\TicketPriority::class)
        @case(Ticket\TicketStatus::class)
            <!-- Value -->
            <x-table.element>
                <div class="flex items-center justify-center">{{ $data->value }}</div>
            </x-table.element>

            <!-- Color -->
            <x-table.element.label :color="$data->color">
                {{ $data->color }}
            </x-table.element.label>
            @break

        @case(Contract\ContractStatus::class)
            <!-- Value -->
            <x-table.element>
                <div class="flex items-center justify-center">{{ $data->value }}</div>
            </x-table.element>

            <!-- Conditions -->
            <x-table.element>
                @empty($data->conditions)
                    <p class="italic">Aucune Condition</p>
                @else
                    @foreach($data->conditions as $column => $infos)
                        <p class="text-xs">
                            {{ Str::of($column)->replace('_', ' ')->title() }} :
                            <span class="font-semibold">
                                @isset($infos['condition'])
                                    {{ $infos['condition'] }}
                                @endisset

                                @isset($infos['value'])
                                    @if(Carbon::hasFormat($infos['value'], 'Y-m-d\TH:i'))
                                        {{ Carbon::parse($infos['value'])->format('Y-m-d H:i') }}
                                    @else
                                        {{ $infos['value'] }}%
                                    @endif
                                @else
                                    Moment de comparaison
                                @endisset

                                @switch($infos['logic'] ?? null)
                                    @case('&&') - « ET » @break
                                    @case('||') - « OU » @break
                                @endswitch
                            </span>
                        </p>

                    @endforeach
                @endempty
            </x-table.element>

            <!-- Color -->
            <x-table.element.label :color="$data->color">
                {{ $data->color }}
            </x-table.element.label>
            @break

        @case(Contract\ContractType::class)
            <!-- Duration -->
            <x-table.element.duration :duration="$data->duration"/>

            <!-- Monthly -->
            <x-table.element.boolean :valid="$data->monthly"/>
            @break

        @case(User\Role::class)
            <x-table.element/>

            <!-- Permission Admin -->
            <x-table.element.boolean :valid="$data->permission_admin"/>

            <!-- Permission Technician -->
            <x-table.element.boolean :valid="$data->permission_technician"/>

            <!-- Permission Client -->
            <x-table.element.boolean :valid="$data->permission_client"/>
            @break

    @endswitch

    <!-- Actions -->
    <td class="flex items-center justify-end gap-1">
        @if($edit)
            @if(get_class($data) === Contract\ContractType::class
                    && $number > 0)
                <x-button size="sm" color="link" title="Ne doit pas être utilisé pour pouvoir être modifié."
                          :href="route(Str::beforeLast(Route::currentRouteName(), '.') .  '.view', ['id' => $data->id])">
                    Voir
                </x-button>
            @else
                <x-button size="sm" color="link"
                          :href="route(Str::beforeLast(Route::currentRouteName(), '.') .  '.edit', ['id' => $data->id])">
                    Modifier
                </x-button>
            @endif

            <x-form method="delete"
                    :action="route(Str::beforeLast(Route::currentRouteName(), '.') .  '.delete', ['id' => $data->id])"
                    :title="$number > 0 ? 'Ne doit pas être utilisé pour pouvoir être supprimé.' : ''">
                <x-button type="submit"
                          size="sm" color="link" icon="trash-2"
                          class="negative" :disabled="$number > 0">
                    Supprimer
                </x-button>
            </x-form>
        @else
            <x-button size="sm" color="link"
                      :href="route(Str::beforeLast(Route::currentRouteName(), '.') .  '.view', ['id' => $data->id])">
                Voir
            </x-button>
        @endif
    </td>
</tr>
