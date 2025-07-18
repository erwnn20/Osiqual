@php use Illuminate\Support\Facades\Auth; @endphp

@props([])

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
            </div>

        </x-page.content>

    </x-page.main>
</x-page.layout>
