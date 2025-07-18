@php
    use App\Models\Contract;use App\Models\Ticket;use App\Models\User;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Route;use Illuminate\Support\Str; @endphp

@props([
    'status',
    'linked',

    'icon',
    'header',
])

<x-page.layout :title="'Visualisation '. $header .' - Osiqual'">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content :icon="$icon" :title="'Visualisation '. $header">

            <x-form method="patch"
                    :action="route(Str::beforeLast(Route::currentRouteName(), '.') .  '.edit', ['id' => $status->id])">

                <div>
                    @if (session('success'))
                        <x-card.notification class="mb-4" color="#00B112">
                            {{ session('success') }}
                        </x-card.notification>
                    @endif

                    <x-form.part title="Informations">

                        @switch(get_class($status))

                            @case(Contract\ContractStatus::class)
                            @case(Ticket\TicketCriticality::class)
                            @case(Ticket\TicketPriority::class)
                            @case(Ticket\TicketStatus::class)
                                <div class="flex gap-2.5">
                                    <x-input type="text"
                                             name="name"
                                             label="Nom"
                                             placeholder="Ex. : En attente, Résolu, En cours, Haute, Faible..."
                                             :value="old('name', $status->name)"
                                             :error="$errors->first('name')"
                                             readonly
                                             class="w-3/5"
                                    />
                                    <x-input type="number"
                                             name="value"
                                             label="Valeur"
                                             placeholder="Ex. : 10"
                                             :value="old('value', $status->value)"
                                             :error="$errors->first('value')"
                                             readonly
                                             class="w-1/5"
                                    />
                                    <x-input type="color"
                                             name="color"
                                             label="Couleur"
                                             :value="old('color', $status->color)"
                                             :error="$errors->first('color')"
                                             labelPosition="top"
                                             readonly
                                             class="w-1/5"
                                    />
                                </div>
                                <div class="flex gap-1.5 ms-auto">
                                    <p class="p-3 text-sm font-semibold">
                                        Aperçu :
                                        <span
                                            class="px-2 py-0.5 rounded text-xs font-semibold tracking-wide uppercase label"
                                            style="background-color: {{ $status->color }}26; color: {{ $status->color }}">
                                    {{ $status->name }}
                                </span>
                                    </p>
                                    <p class="p-3 rounded-lg bg-default-950
                                          text-default-200 text-sm font-semibold">
                                        Inverse :
                                        <span
                                            class="px-2 py-0.5 rounded text-xs font-semibold tracking-wide uppercase label"
                                            style="background-color: {{ $status->color }}26; color: {{ $status->color }}">
                                    {{ $status->name }}
                                </span>
                                    </p>
                                </div>
                                @break

                            @case(Contract\ContractType::class)
                                <x-input type="text"
                                         name="name"
                                         label="Durée du Contrat (en heures)"
                                         placeholder="Ex. : 5"
                                         :value="old('name', $status->name)"
                                         :error="$errors->first('name')"
                                         readonly
                                />
                                <x-input type="number"
                                         name="duration"
                                         label="Durée du Contrat (en heures)"
                                         placeholder="Ex. : 5"
                                         :value="old('duration', $status->duration / 60)"
                                         :error="$errors->first('duration')"
                                         readonly
                                         :min="0"
                                />
                                <x-input type="checkbox"
                                         name="monthly"
                                         label="Contrat Mensuel"
                                         :value="true"
                                         :checked="old('monthly', $status->monthly)"
                                         :error="$errors->first('monthly')"
                                         readonly
                                />
                                @break

                            @case(User\Role::class)
                                <x-input type="text"
                                         name="name"
                                         label="Nom"
                                         placeholder="Ex. : Administrateur, Technicien..."
                                         :value="old('name', $status->name)"
                                         :error="$errors->first('name')"
                                         readonly
                                />
                                <div class="flex gap-2.5 justify-around">
                                    <x-input type="checkbox"
                                             name="admin"
                                             label="Permission Administrateur"
                                             :value="true"
                                             :checked="old('admin', $status->permission_admin)"
                                             :error="$errors->first('admin')"
                                             readonly
                                    />
                                    <x-input type="checkbox"
                                             name="tech"
                                             label="Permission Technicien"
                                             :value="true"
                                             :checked="old('tech', $status->permission_technician)"
                                             :error="$errors->first('tech')"
                                             readonly
                                    />
                                    <x-input type="checkbox"
                                             name="client"
                                             label="Permission Client"
                                             :value="true"
                                             :checked="old('client', $status->permission_client)"
                                             :error="$errors->first('client')"
                                             readonly
                                    />
                                </div>
                                @break

                        @endswitch

                    </x-form.part>
                </div>

            </x-form>

            <x-table :data="$linked['data']" :error="$linked['error']"
                     :filter="false" :edit="$linked['edit'] ?? false">
                <div class="flex gap-3">
                    <div class="flex items-center gap-2.5">
                        <h3 class="text-2xl/tight font-bold">{{ $linked['title'] }}</h3>

                        <span class="px-2 py-0.5 rounded-full
                                         text-sm font-semibold tracking-wide uppercase
                                         bg-default-800/15 text-default-800">
                                {{ $linked['data'] instanceof LengthAwarePaginator
                                    ? $linked['data']->total() : $linked['data']->count() }}
                            </span>
                    </div>
                </div>
            </x-table>

        </x-page.content>

    </x-page.main>
</x-page.layout>
