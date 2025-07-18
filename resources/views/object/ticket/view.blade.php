@php use Carbon\Carbon;use Illuminate\Support\Facades\Auth; @endphp

@props([
    'ticket',

    'clients',
    'technicians',
    'statuses',
    'priorities',
    'criticalities',
])

<x-page.layout title="Visualisation Ticket - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="ticket" title="Visualisation Ticket">

            <x-form method="post">

                <x-form.part title="Informations">
                    <x-input type="text"
                             name="title"
                             label="Titre du Ticket"
                             placeholder="Ex: Problème de connexion réseau..."
                             :value="old('title', $ticket->title)"
                             :error="$errors->first('title')"
                             readonly
                    />
                    <x-input type="textarea"
                             name="description"
                             label="Description"
                             placeholder="Décrivez en détail le problème rencontré..."
                             :value="old('description', $ticket->description)"
                             :error="$errors->first('description')"
                             readonly
                    />
                    <div class="flex gap-2.5">
                        <x-input type="select"
                                 name="client"
                                 label="Client"
                                 placeholder="Sélectionnez un Client"
                                 :value="old('client', $ticket->client_id)"
                                 :error="$errors->first('client')"
                                 :options="$clients"
                                 readonly
                                 class="w-full"
                        />
                        <x-input type="select"
                                 name="technician"
                                 label="Technicien"
                                 placeholder="Sélectionnez un Technicien"
                                 :value="old('technician', $ticket->technician_id)"
                                 :error="$errors->first('technician')"
                                 :options="$technicians"
                                 readonly
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
                             readonly
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
                                 readonly
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
                                 :value="old('status', $ticket->status_id)"
                                 :error="$errors->first('status')"
                                 :options="$statuses"
                                 readonly
                                 class="w-full"
                        />
                        <x-input type="select"
                                 name="priority"
                                 label="Priorité"
                                 placeholder="-"
                                 :value="old('priority', $ticket->priority_id)"
                                 :error="$errors->first('priority')"
                                 :options="$priorities"
                                 readonly
                                 class="w-full"
                        />
                        <x-input type="select"
                                 name="criticality"
                                 label="Criticité"
                                 placeholder="-"
                                 :value="old('criticality', $ticket->criticality_id)"
                                 :error="$errors->first('criticality')"
                                 :options="$criticalities"
                                 readonly
                                 class="w-full"
                        />
                    </div>
                </x-form.part>

            </x-form>

            @if($ticket->steps->count() > 0)
                <x-form.part title="Étapes">

                    @foreach($ticket->steps()->orderBy('date')->get() as $key => $step)

                        @php $technician = $step->technician @endphp
                        @php $date = Carbon::parse($step->date) @endphp

                        <div @class(['flex', 'flex-col', 'gap-2', 'border-b-default-300',
                                 'pb-3' => $key < $ticket->steps->count() - 1,
                                 'border-b' => $key < $ticket->steps->count() - 1])>
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
                            </div>

                            <p class="text-pretty font-semibold">{{ $step->description }}</p>
                        </div>

                    @endforeach

                </x-form.part>
            @endif

        </x-page.content>

    </x-page.main>
</x-page.layout>
