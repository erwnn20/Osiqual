@php use App\Models\Contract;use App\Models\Ticket;use App\Models\User;use Illuminate\Pagination\LengthAwarePaginator;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Route; @endphp

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
                @if ($errors->first('error'))
                    <x-card.notification class="mb-4" color="#DA3636">
                        {{ $errors->first('error') }}
                    </x-card.notification>
                @endif

                <x-table :data="$data" :filter="false" :edit="$edit">
                    <div class="flex items-center gap-2.5">
                        <h3 class="text-2xl/tight font-bold">{{ $title }}</h3>

                        <span class="px-2 py-0.5 rounded-full
                                         text-sm font-semibold tracking-wide uppercase
                                         bg-default-800/15 text-default-800">
                            {{ $data instanceof LengthAwarePaginator ? $data->total() : $data->count() }}
                        </span>

                        @if(get_class($data->first()) === Contract\ContractStatus::class)
                            <small class="h-full italic text-default-500">
                                Les conditions seront vérifiées dans l’ordre décroissant des valeurs.
                            </small>
                        @endif
                    </div>
                </x-table>
            </div>

            @if($create)
                <x-form method="post"
                        :action="route(Str::beforeLast(Route::currentRouteName(), '.') .  '.new')">

                    <x-form.part :title="'Nouveau '. $header "
                                 :submit="['text' => 'Créer', 'icon' => 'plus']">

                        @switch(get_class($data->first()))

                            @case(Ticket\TicketCriticality::class)
                            @case(Ticket\TicketPriority::class)
                            @case(Ticket\TicketStatus::class)
                                <div class="flex gap-2.5">
                                    <x-input type="text"
                                             name="name"
                                             label="Nom"
                                             placeholder="Ex. : En attente, Résolu, En cours, Haute, Faible..."
                                             :value="old('name')"
                                             :error="$errors->first('name')"
                                             required
                                             class="w-3/5"
                                    />
                                    <x-input type="number"
                                             name="value"
                                             label="Valeur"
                                             placeholder="Ex. : 10"
                                             :value="old('value')"
                                             :error="$errors->first('value')"
                                             required
                                             class="w-1/5"
                                    />
                                    <x-input type="color"
                                             name="color"
                                             label="Couleur"
                                             :value="old('color', '#0683A2')"
                                             :error="$errors->first('color')"
                                             labelPosition="top"
                                             required
                                             class="w-1/5"
                                    />
                                </div>
                                <div class="flex gap-1.5 ms-auto">
                                    <p class="p-3 text-sm font-semibold">
                                        Aperçu :
                                        <span
                                            class="px-2 py-0.5 rounded text-xs font-semibold tracking-wide uppercase label">
                                    label
                                </span>
                                    </p>
                                    <p class="p-3 rounded-lg bg-default-950
                                          text-default-200 text-sm font-semibold">
                                        Inverse :
                                        <span
                                            class="px-2 py-0.5 rounded text-xs font-semibold tracking-wide uppercase label">
                                    label
                                </span>
                                    </p>

                                    @once
                                        @vite('resources/js/scripts/status/updateLabels.js')
                                    @endonce
                                </div>
                                @break

                            @case(Contract\ContractStatus::class)
                                <div class="flex gap-2.5">
                                    <x-input type="text"
                                             name="name"
                                             label="Nom"
                                             placeholder="Ex. : En attente, Résolu, En cours, Haute, Faible..."
                                             :value="old('name')"
                                             :error="$errors->first('name')"
                                             required
                                             class="w-3/5"
                                    />
                                    <x-input type="number"
                                             name="value"
                                             label="Valeur"
                                             placeholder="Ex. : 10"
                                             :value="old('value')"
                                             :error="$errors->first('value')"
                                             required
                                             class="w-1/5"
                                    />
                                    <x-input type="color"
                                             name="color"
                                             label="Couleur"
                                             :value="old('color', '#0683A2')"
                                             :error="$errors->first('color')"
                                             labelPosition="top"
                                             required
                                             class="w-1/5"
                                    />
                                </div>
                                <div class="flex gap-1.5 ms-auto">
                                    <p class="p-3 text-sm font-semibold">
                                        Aperçu :
                                        <span
                                            class="px-2 py-0.5 rounded text-xs font-semibold tracking-wide uppercase label">
                                    label
                                </span>
                                    </p>
                                    <p class="p-3 rounded-lg bg-default-950
                                          text-default-200 text-sm font-semibold">
                                        Inverse :
                                        <span
                                            class="px-2 py-0.5 rounded text-xs font-semibold tracking-wide uppercase label">
                                    label
                                </span>
                                    </p>

                                    @once
                                        @vite('resources/js/scripts/status/updateLabels.js')
                                    @endonce
                                </div>
                                <div>
                                    <x-input type="hidden" label="Conditions"
                                             assistiveText="Dates reliées par un « ET » logique"
                                             name=""
                                    />
                                    <div class="grid grid-cols-3 gap-2.5">
                                        <x-input.fieldset legend="Debut du Contrat">
                                            <x-input type="radio"
                                                     name="start-condition"
                                                     label="Aucune"
                                                     :error="$errors->first('start-condition')"
                                                     :checked="empty(old('start-condition'))"
                                            />
                                            <x-input type="radio"
                                                     name="start-condition"
                                                     label="Inférieur à (<)"
                                                     value="<"
                                                     :error="$errors->first('start-condition')"
                                            />
                                            <x-input type="checkbox"
                                                     name="start-condition-equal"
                                                     label="Égale à (=)"
                                                     value="="
                                                     :error="$errors->first('start-condition-equal')"
                                            />
                                            <x-input type="radio"
                                                     name="start-condition"
                                                     label="Supérieur à (>)"
                                                     value=">"
                                                     :error="$errors->first('start-condition')"
                                            />
                                            <x-input type="datetime-local"
                                                     name="start-value"
                                                     label="Date de comparaison"
                                                     :value="old('start-value')"
                                                     assistiveText="Laisser vide pour comparer à la date du moment."
                                                     :error="$errors->first('start-value')"
                                                     class="mt-1"
                                            />
                                            <x-input type="hidden"
                                                     name="start-column"
                                                     value="start_date"
                                                     :error="$errors->first('start-column')"
                                            />
                                            <x-input type="hidden"
                                                     name="start-type"
                                                     value="date"
                                                     :error="$errors->first('start-type')"
                                            />
                                        </x-input.fieldset>
                                        <x-input.fieldset legend="Fin du Contrat">
                                            <x-input type="radio"
                                                     name="end-condition"
                                                     label="Aucune"
                                                     :error="$errors->first('end-condition')"
                                                     :checked="empty(old('end-condition'))"
                                            />
                                            <x-input type="radio"
                                                     name="end-condition"
                                                     label="Inférieur à (<)"
                                                     value="<"
                                                     :error="$errors->first('end-condition')"
                                            />
                                            <x-input type="checkbox"
                                                     name="end-condition-equal"
                                                     label="Égale à (=)"
                                                     value="="
                                                     :error="$errors->first('end-condition-equal')"
                                            />
                                            <x-input type="radio"
                                                     name="end-condition"
                                                     label="Supérieur à (>)"
                                                     value=">"
                                                     :error="$errors->first('end-condition')"
                                            />
                                            <x-input type="datetime-local"
                                                     name="end-value"
                                                     label="Date de comparaison"
                                                     :value="old('end-value')"
                                                     assistiveText="Laisser vide pour comparer à la date du moment."
                                                     :error="$errors->first('end-value')"
                                                     class="mt-1"
                                            />
                                            <x-input type="hidden"
                                                     name="end-column"
                                                     value="end_date"
                                                     :error="$errors->first('end-column')"
                                            />
                                            <x-input type="hidden"
                                                     name="end-type"
                                                     value="date"
                                                     :error="$errors->first('end-type')"
                                            />
                                        </x-input.fieldset>
                                        <x-input.fieldset legend="Consommation du Contrat">
                                            <div class="flex justify-between">
                                                <div class="flex flex-col gap-3">
                                                    <x-input type="radio"
                                                             name="consumption-condition"
                                                             label="Aucune"
                                                             :error="$errors->first('consumption-condition')"
                                                             :checked="empty(old('consumption-condition'))"
                                                    />
                                                    <x-input type="radio"
                                                             name="consumption-condition"
                                                             label="Inférieur à (<)"
                                                             value="<"
                                                             :error="$errors->first('consumption-condition')"
                                                    />
                                                    <x-input type="checkbox"
                                                             name="consumption-condition-equal"
                                                             label="Égale à (=)"
                                                             value="="
                                                             :error="$errors->first('consumption-condition-equal')"
                                                    />
                                                    <x-input type="radio"
                                                             name="consumption-condition"
                                                             label="Supérieur à (>)"
                                                             value=">"
                                                             :error="$errors->first('consumption-condition')"
                                                    />
                                                </div>
                                                <x-input type="select"
                                                         name="consumption-logic"
                                                         :value="old('consumption-logic')"
                                                         :error="$errors->first('consumption-logic')"
                                                         :options="[['value' => '&&', 'label' => 'ET'],
                                                                    ['value' => '||', 'label' => 'OU']]"
                                                />
                                            </div>
                                            <x-input type="range"
                                                     name="consumption-value"
                                                     label="Part du Contrat Consommé (%)"
                                                     :value="old('consumption-value')"
                                                     :error="$errors->first('consumption-value')"
                                                     required

                                                     :min="0"
                                                     :max="100"
                                                     :step="5"
                                                     class="mt-1"
                                            />
                                            <x-input type="hidden"
                                                     name="consumption-type"
                                                     value="percent"
                                                     :error="$errors->first('consumption-type')"
                                            />
                                        </x-input.fieldset>

                                        @once
                                            @vite('resources/js/scripts/status/updateConditions.js')
                                        @endonce
                                    </div>
                                </div>
                                @break

                            @case(Contract\ContractType::class)
                                <x-input type="number"
                                         name="duration"
                                         label="Durée du Contrat (en heures)"
                                         placeholder="Ex. : 5"
                                         :value="old('duration')"
                                         :error="$errors->first('duration')"
                                         required
                                         :min="0"
                                />
                                <x-input type="checkbox"
                                         name="monthly"
                                         label="Contrat Mensuel"
                                         :value="true"
                                         :checked="old('monthly')"
                                         :error="$errors->first('monthly')"
                                />
                                @break

                            @case(User\Role::class)
                                <x-input type="text"
                                         name="name"
                                         label="Nom"
                                         placeholder="Ex. : Administrateur, Technicien..."
                                         :value="old('name')"
                                         :error="$errors->first('name')"
                                         required
                                />
                                <div class="flex gap-2.5 justify-around">
                                    <x-input type="checkbox"
                                             name="admin"
                                             label="Permission Administrateur"
                                             :value="true"
                                             :checked="old('admin')"
                                             :error="$errors->first('admin')"
                                    />
                                    <x-input type="checkbox"
                                             name="tech"
                                             label="Permission Technicien"
                                             :value="true"
                                             :checked="old('tech')"
                                             :error="$errors->first('tech')"
                                    />
                                    <x-input type="checkbox"
                                             name="client"
                                             label="Permission Client"
                                             :value="true"
                                             :checked="old('client')"
                                             :error="$errors->first('client')"
                                    />
                                </div>
                                @break

                        @endswitch


                    </x-form.part>

                </x-form>
            @endif

        </x-page.content>

    </x-page.main>
</x-page.layout>
