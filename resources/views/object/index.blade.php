@php use Illuminate\Pagination\LengthAwarePaginator;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Route; @endphp

@props([
    'cards',
    'data',
    'create',
    'edit',

    'icon',
    'header',
    'title',
])

<x-page.layout :title="$header .' - Osiqual'">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content :icon="$icon" :title="$header">

            @if(!empty($cards))
                <div class="flex gap-5">
                    @foreach($cards as $card)
                        <x-card.info :icon="$card['icon']" :value="$card['value']">
                            <p class="text-lg font-semibold">{{ $card['title'] }}</p>
                        </x-card.info>
                    @endforeach
                </div>
            @endif

            <div>
                @if (session('success'))
                    <x-card.notification class="mb-4" color="#00B112">
                        {{ session('success') }}
                    </x-card.notification>
                @endif

                <x-table :data="$data" :filter="true" :edit="$edit">
                    <div class="flex gap-3">
                        <div class="flex items-center gap-2.5">
                            <h3 class="text-2xl/tight font-bold">{{ $title }}</h3>

                            <span class="px-2 py-0.5 rounded-full
                                         text-sm font-semibold tracking-wide uppercase
                                         bg-default-800/15 text-default-800">
                            {{ $data instanceof LengthAwarePaginator ? $data->total() : $data->count() }}
                        </span>
                        </div>

                        @if($create)
                            <x-button :href="route(Str::beforeLast(Route::currentRouteName(), '.') .  '.new')"
                                      class="ms-auto" icon="plus" size="md">
                                Nouveau
                            </x-button>
                        @endif
                    </div>
                </x-table>
            </div>

        </x-page.content>

    </x-page.main>
</x-page.layout>
