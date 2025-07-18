@php use Illuminate\Support\Facades\Route; @endphp

@props([
    'user'
])

<x-navbar :user="$user">

    <x-navbar.element.part title="Clients">
        <x-navbar.element.link :href="route('ticket.index')" icon="ticket"
                               :active="Route::currentRouteName() === 'ticket.index'">
            Tickets
        </x-navbar.element.link>
        <x-navbar.element.link :href="route('contract.index')" icon="file-text"
                               :active="Route::currentRouteName() === 'contract.index'">
            Contrats
        </x-navbar.element.link>
        <x-navbar.element.link :href="route('company.index')" icon="building-2"
                               :active="Route::currentRouteName() === 'company.index'">
            Sociétés
        </x-navbar.element.link>
    </x-navbar.element.part>

    <x-navbar.element.part title="Administrateur">
        <x-navbar.element.link :href="route('user.index')" icon="users"
                               :active="Route::currentRouteName() === 'user.index'">
            Utilisateurs
        </x-navbar.element.link>

        <x-navbar.element.part title="Status et Rôles">
            <x-navbar.element.link :href="route('ticket.status.index')" icon="ticket"
                                   :active="Route::currentRouteName() === 'ticket.status.index'"
                                   size="sm">
                Status de Ticket
            </x-navbar.element.link>
            <x-navbar.element.link :href="route('ticket.priority.index')" icon="ticket"
                                   :active="Route::currentRouteName() === 'ticket.priority.index'"
                                   size="sm">
                Priorités de Ticket
            </x-navbar.element.link>
            <x-navbar.element.link :href="route('ticket.criticality.index')" icon="ticket"
                                   :active="Route::currentRouteName() === 'ticket.criticality.index'"
                                   size="sm">
                Criticités de Ticket
            </x-navbar.element.link>

            <x-navbar.element.link :href="route('contract.status.index')" icon="file-text"
                                   :active="Route::currentRouteName() === 'contract.status.index'"
                                   size="sm">
                Status de Contrat
            </x-navbar.element.link>
            <x-navbar.element.link :href="route('contract.type.index')" icon="file-text"
                                   :active="Route::currentRouteName() === 'contract.type.index'"
                                   size="sm">
                Types de Contrat
            </x-navbar.element.link>

            <x-navbar.element.link :href="route('user.role.index')" icon="user"
                                   :active="Route::currentRouteName() === 'user.role.index'"
                                   size="sm">
                Rôles d'Utilisateur
            </x-navbar.element.link>
        </x-navbar.element.part>
    </x-navbar.element.part>

</x-navbar>
