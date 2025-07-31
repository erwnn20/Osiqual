@php use Carbon\Carbon;use Illuminate\Support\Facades\Auth; @endphp

@props([
    'ticket',
    'delete',

    'clients',
    'technicians',
    'statuses',
    'priorities',
    'criticalities',
])

<x-page.layout title="Modification Ticket - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="ticket" title="Modification Ticket">

            <x-form method="patch"
                    :action="route('ticket.edit', ['id' => $ticket->id])">

                <div>
                    @if (session('success'))
                        <x-card.notification class="mb-4" color="#00B112">
                            {{ session('success') }}
                        </x-card.notification>
                    @endif

                    <x-form.part title="Informations"
                                 :submit="['text' => 'Enregister', 'icon' => 'save']"
                                 :buttons="[['active' => $delete,
                                             'type' => 'submit', 'text' => 'Supprimer',
                                             'icon' => 'trash-2', 'size' => 'md', 'color' => 'link',
                                             'class' => 'negative mx-1.5', 'form' => 'delete']]">
                        <x-input type="text"
                                 name="title"
                                 label="Titre du Ticket"
                                 placeholder="Ex: Problème de connexion réseau..."
                                 :value="old('title', $ticket->title)"
                                 :error="$errors->first('title')"
                                 required
                        />
                        <x-input type="textarea"
                                 name="description"
                                 label="Description"
                                 placeholder="Décrivez en détail le problème rencontré..."
                                 :value="old('description', $ticket->description)"
                                 :error="$errors->first('description')"
                        />
                        <div class="flex gap-2.5">
                            <x-input type="select"
                                     name="client"
                                     label="Client"
                                     placeholder="Sélectionnez un Client"
                                     :value="old('client', $ticket->client_id)"
                                     :error="$errors->first('client')"
                                     :options="$clients"
                                     required
                                     class="w-full"
                            />
                            <x-input type="select"
                                     name="technician"
                                     label="Technicien"
                                     placeholder="Sélectionnez un Technicien"
                                     :value="old('technician', $ticket->technician_id)"
                                     :error="$errors->first('technician')"
                                     :options="$technicians"
                                     class="w-full"
                            />
                        </div>
                        <x-input type="number"
                                 name="duration"
                                 label="Durée d’intervention (en minutes)"
                                 placeholder="Ex: 30"
                                 :value="old('duration', $ticket->duration)"
                                 :error="$errors->first('duration')"
                                 :min="0"
                        />
                        <div class="flex gap-2.5">
                            <x-input type="datetime-local"
                                     name="creation"
                                     label="Date de Création"
                                     :value="old('creation', $ticket->creation_date)"
                                     :error="$errors->first('creation')"
                                     :step="60"
                                     readonly
                                     class="w-full"
                            />
                            <x-input type="datetime-local"
                                     name="end"
                                     label="Date de Fin"
                                     :value="old('end', $ticket->end_date)"
                                     :error="$errors->first('end')"
                                     :step="60"
                                     class="w-full"
                            />
                        </div>
                    </x-form.part>
                </div>

                <x-form.part title="Status">
                    <div class="flex gap-2.5">
                        <x-input type="select"
                                 name="status"
                                 label="Status"
                                 placeholder="-"
                                 :value="old('status', $ticket->status_id)"
                                 :error="$errors->first('status')"
                                 :options="$statuses"
                                 required
                                 class="w-full"
                        />
                        <x-input type="select"
                                 name="priority"
                                 label="Priorité"
                                 placeholder="-"
                                 :value="old('priority', $ticket->priority_id)"
                                 :error="$errors->first('priority')"
                                 :options="$priorities"
                                 required
                                 class="w-full"
                        />
                        <x-input type="select"
                                 name="criticality"
                                 label="Criticité"
                                 placeholder="-"
                                 :value="old('criticality', $ticket->criticality_id)"
                                 :error="$errors->first('criticality')"
                                 :options="$criticalities"
                                 required
                                 class="w-full"
                        />
                    </div>
                </x-form.part>

            </x-form>

            @if($delete)
                <x-form id="delete" method="delete"
                        :action="route('ticket.delete', ['id' => $ticket->id])"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?')">
                </x-form>
            @endif

            <div>
                @if (session('success_step'))
                    <x-card.notification class="mb-4" color="#00B112">
                        {{ session('success_step') }}
                    </x-card.notification>
                @endif

                <x-form.part title="Étapes" id="steps">

                    @foreach($ticket->steps()->orderBy('date')->get() as $step)

                        @php $technician = $step->technician @endphp
                        @php $date = Carbon::parse($step->date) @endphp

                        <div class="flex flex-col gap-2 pb-3 border-b border-b-default-300">
                            <div class="flex gap-2">
                                <p class="text-primary">
                                    par
                                    <span class="font-semibold">
                                    {{ ($technician->firstname ? "$technician->firstname " : "") . $technician->lastname }}
                                </span>
                                    le
                                    <span class="font-semibold">{{ $date->translatedFormat('d F Y') }}</span>
                                    à
                                    <span class="font-semibold">{{ $date->translatedFormat('G:i') }}</span>
                                </p>

                                <x-form class="ms-auto" method="delete"
                                        :action="route('ticket.step.delete', ['ticket' => $ticket->id, 'id' => $step->id]).'#steps'"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette étape de ticket ?')">
                                    <x-button type="submit" color="link" class="negative" icon="trash-2">
                                        Supprimer
                                    </x-button>
                                </x-form>
                            </div>

                            <p class="max-w-7xl text-pretty font-semibold">{{ $step->description }}</p>
                        </div>

                    @endforeach

                    <x-form gap="gap-3" method="post"
                            :action="route('ticket.step.new', ['ticket' => $ticket->id]).'#steps'">
                        <div class="flex gap-2.5">
                            <x-input type="select"
                                     name="step_technician"
                                     label="Technicien"
                                     placeholder="Sélectionnez un Technicien"
                                     :value="old('step_technician', Auth::user()->id)"
                                     :error="$errors->first('step_technician')"
                                     :options="$technicians"
                                     required
                                     class="w-full"
                            />
                            <x-input type="datetime-local"
                                     name="step_date"
                                     label="Date"
                                     :value="old('step_date')"
                                     :error="$errors->first('step_date')"
                                     required
                            />
                        </div>
                        <x-input type="textarea"
                                 name="step_description"
                                 label="Description"
                                 placeholder="Décrivez en détail l'étape de l'intervention..."
                                 :value="old('description')"
                                 :error="$errors->first('description')"
                        />

                        <x-button class="ms-auto" type="submit" icon="plus">Ajouter</x-button>
                    </x-form>

                </x-form.part>
            </div>

        </x-page.content>

    </x-page.main>
</x-page.layout>
