@php use Illuminate\Support\Facades\Route; @endphp

@props([
    'user'
])

<x-navbar :user="$user">

    <x-navbar.element.part title="Vos Informations">
        <x-navbar.element.link :href="route('ticket.index')" icon="ticket"
                               :active="Route::currentRouteName() === 'ticket.index'">
            Tickets
        </x-navbar.element.link>
        <x-navbar.element.link :href="route('contract.index')" icon="file-text"
                               :active="Route::currentRouteName() === 'contract.index'">
            Contrats
        </x-navbar.element.link>
        <x-navbar.element.link :href="route('company.self')" icon="building-2"
                               :active="Route::currentRouteName() === 'company.index'">
            Société
        </x-navbar.element.link>
    </x-navbar.element.part>

</x-navbar>
