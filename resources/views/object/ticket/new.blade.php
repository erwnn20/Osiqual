@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'clients',
    'technicians',
    'statuses',
    'priorities',
    'criticalities',
])

<x-page.layout title="Creation Ticket - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="ticket" title="Creation Ticket">

            <x-form method="post">

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
                    />
                    <div class="flex gap-2.5">
                        <x-input type="select"
                                 name="client"
                                 label="Client"
                                 placeholder="Sélectionnez un Client"
                                 :value="old('client')"
                                 :error="$errors->first('client')"
                                 :options="$clients"
                                 class="w-full"
                                 required
                        />
                        <x-input type="select"
                                  name="technician" label="Technicien"
                                  placeholder="Sélectionnez un Technicien"
                                  :value="old('technician', Auth::user()->id)"
                                  :error="$errors->first('technician')"
                                  :options="$technicians"
                                  class="w-full"
                        />
                    </div>
                    <x-input type="number"
                             name="duration"
                             label="Durée d’intervention (en minutes)"
                             placeholder="Ex: 30"
                             :value="old('duration')"
                             :error="$errors->first('duration')"
                             :min="0"
                    />
                    <div class="flex gap-2.5">
                        <x-input type="datetime-local"
                                 name="creation"
                                 label="Date de Création"
                                 :value="old('creation')"
                                 :error="$errors->first('creation')"
                                 :step="60"
                                 class="w-full"
                        />
                        <x-input type="datetime-local"
                                 name="end"
                                 label="Date de Fin"
                                 :value="old('end')"
                                 :error="$errors->first('end')"
                                 :step="60"
                                 class="w-full"
                        />
                    </div>
                </x-form.part>

                <x-form.part title="Status">
                    <div class="flex gap-2.5">
                        <x-input type="select"
                                 name="status"
                                 label="Status"
                                 placeholder="-"
                                 :value="old('status')"
                                 :error="$errors->first('status')"
                                 :options="$statuses"
                                 required
                                 class="w-full"
                        />
                        <x-input type="select"
                                 name="priority"
                                 label="Priorité"
                                 placeholder="-"
                                 :value="old('priority')"
                                 :error="$errors->first('priority')"
                                 :options="$priorities"
                                 required
                                 class="w-full"
                        />
                        <x-input type="select"
                                 name="criticality"
                                 label="Criticité"
                                 placeholder="-"
                                 :value="old('criticality')"
                                 :error="$errors->first('criticality')"
                                 :options="$criticalities"
                                 required
                                 class="w-full"
                        />
                    </div>
                </x-form.part>

            </x-form>

        </x-page.content>

    </x-page.main>
</x-page.layout>
