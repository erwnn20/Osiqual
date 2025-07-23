@php use App\Models\Contract;use App\Models\Ticket;use App\Models\User; @endphp
@props([
    'data'
])

<tr>
    <th scope="col" class="ps-6">
        Nom
    </th>
    <th scope="col">
        Nombre d'Apparition
    </th>

    @switch(get_class($data))

        @case(Ticket\TicketCriticality::class)
        @case(Ticket\TicketPriority::class)
        @case(Ticket\TicketStatus::class)
            <th scope="col">
                Valeur
            </th>
            <th scope="col">
                Couleur
            </th>
            @break

        @case(Contract\ContractStatus::class)
            <th scope="col">
                Valeur
            </th>
            <th scope="col">
                Conditions
            </th>
            <th scope="col">
                Couleur
            </th>
            @break

        @case(Contract\ContractType::class)
            <th scope="col">
                Durée
            </th>
            <th scope="col">
                Mensuel
            </th>
            @break

        @case(User\Role::class)
            <th scope="col">
                Permissions :
            </th>
            <th scope="col">
                Administrateur
            </th>
            <th scope="col">
                Technicien
            </th>
            <th scope="col">
                Client
            </th>
            @break

    @endswitch
    <th scope="col"></th>
</tr>
