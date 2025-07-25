@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'contract'
])

<x-page.layout title="Creation Ticket - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="ticket" title="Creation Ticket">

            <div>
                @if ($errors->first('error'))
                    <x-card.notification class="mb-4" color="#DA3636">
                        {{ $errors->first('error') }}
                    </x-card.notification>
                @endif

                <x-contract.range :contract="$contract"
                                  error="Votre entreprise n'a aucun contrat en cours">
                    <div class="flex items-end gap-3 pb-0.5">
                        <h3 class="text-xl/tight font-semibold italic">Temps de Contrat restant</h3>

                        <div class="flex items-center gap-1">
                            <span class="text-sm italic">Autres contrats en Cours</span>
                            <span class="px-2 py-0.5 rounded-full
                                         text-xs font-semibold tracking-wide uppercase
                                         bg-default-800/15 text-default-800">
                               {{ $contract->company->currentContracts('attributable')
                                                    ->filter(fn($c) => $c->id !== $contract->id)
                                                    ->count() }}
                            </span>
                        </div>
                    </div>
                </x-contract.range>
            </div>

            <x-form :action="route('ticket.new.client')" method="post">

                <x-form.part title="Informations" :submit="['text' => 'Créer', 'icon' => 'plus']">
                    <x-input type="text"
                             name="title"
                             label="Titre du Ticket"
                             placeholder="Ex: Problème de connexion réseau..."
                             :value="old('title')"
                             :error="$errors->first('title')"
                             required
                    />
                    <x-input type="textarea"
                             name="description"
                             label="Description"
                             placeholder="Décrivez en détail le problème rencontré..."
                             :value="old('description')"
                             :error="$errors->first('description')"
                             required
                             class="h-48"
                    />
                </x-form.part>

            </x-form>

        </x-page.content>

    </x-page.main>
</x-page.layout>
