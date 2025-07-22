@php use Illuminate\Support\Carbon;use Illuminate\Support\Facades\Auth; @endphp

@props([
    'companies',
    'types',
    'statuses',
])

<x-page.layout title="Creation Contrat - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="file-text" title="Creation Contrat">

            <x-form method="post">

                <x-form.part title="Informations" :submit="['text' => 'Créer', 'icon' => 'plus']">
                    <x-input type="select"
                             name="company"
                             label="Société"
                             placeholder="Sélectionnez une Société"
                             :value="old('company')"
                             :error="$errors->first('company')"
                             :options="$companies"
                             required
                    />
                    <div class="flex gap-2.5">
                        <x-input type="select"
                                 name="type"
                                 label="Type"
                                 placeholder="Sélectionnez un Type de Contrat"
                                 :options="$types"
                                 :value="old('type')"
                                 :error="$errors->first('type')"
                                 required
                                 class="w-full"
                        />
                        @once
                            @vite('resources/js/scripts/contract/typeSelect.js')
                        @endonce
                    </div>
                    <div class="flex gap-2.5">
                        @php
                            $value = old('start')
                                ? Carbon::parse(old('start'))->format('Y-m-d')
                                : null;
                        @endphp
                        <x-input type="date"
                                 name="start"
                                 label="Date de Début"
                                 :value="$value"
                                 :error="$errors->first('start')"
                                 required
                                 class="w-full"
                        />
                        @php
                            $value = old('end')
                                ? Carbon::parse(old('end'))->format('Y-m-d')
                                : null;
                        @endphp
                        <x-input type="date"
                                 name="end"
                                 label="Date de Fin"
                                 :value="$value"
                                 :error="$errors->first('end')"
                                 required
                                 class="w-full"
                        />
                    </div>
                </x-form.part>

            </x-form>

        </x-page.content>

    </x-page.main>
</x-page.layout>
