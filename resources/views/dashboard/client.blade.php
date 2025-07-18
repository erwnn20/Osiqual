@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'cards',
    'tickets',
    'contract',
//    'contracts',
])

<x-page.layout title="Dashboard - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="house" title="Dashboard">

            <div>
                <div class="flex gap-5 mb-7">
                    @foreach($cards as $card)
                        <x-card.info :icon="$card['icon']" :value="$card['value']">
                            <p class="text-lg font-semibold">{{ $card['title'] }}</p>
                        </x-card.info>
                    @endforeach
                </div>

                <x-contract.range :contract="$contract"
                                  title="Temps de Contrat restant"
                                  error="Votre entreprise n'a aucun contrat en cours"/>
            </div>

            <x-table :data="$tickets['data']" :filter="false" :edit="$tickets['edit']">
                <div class="flex items-end gap-2">
                    <h3 class="text-2xl/tight font-bold">Vos Derniers Tickets</h3>

                    <x-button :href="route('ticket.index')" size="sm" color="link" class="black">
                        <div class="flex items-center">
                            <span class="italic me-1">Voir tous vos Tickets</span>
                            <span class="px-2 py-0.5 rounded-full
                                         text-xs font-semibold tracking-wide uppercase
                                         bg-default-800/15 text-default-800">
                                {{ $tickets['count'] }}
                            </span>
                            <i class="w-fit py-1 stroke-2" data-lucide="chevron-right"></i>
                        </div>
                    </x-button>
                </div>
            </x-table>

            {{--<x-table :data="$contracts['data']" :filter="false" :edit="$contracts['edit']">
                <div class="flex items-end gap-2">
                    <h3 class="text-2xl/tight font-bold">Vos Derniers Contrats</h3>

                    <x-button href="#" size="sm" color="link" class="black">
                        <div class="flex items-center">
                            <span class="italic me-1">Voir tous vos Contrats</span>
                            <span
                                class="px-2 py-0.5 rounded-full
                                       text-xs font-semibold tracking-wide uppercase
                                       bg-default-800/15 text-default-800">
                                {{ $contracts['count'] }}
                            </span>
                            <i class="w-fit py-1 stroke-2" data-lucide="chevron-right"></i>
                        </div>
                    </x-button>
                </div>
            </x-table>--}}

        </x-page.content>

    </x-page.main>
</x-page.layout>
