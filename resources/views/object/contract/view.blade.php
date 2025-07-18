@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'contract',

    'companies',
    'types',
    'statuses',
])

<x-page.layout title="Visualisation Contrat - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="file-text" title="Visualisation Contrat">

            <x-form method="post">

                <x-form.part title="Informations">
                    <x-input type="select"
                             name="company"
                             label="Société"
                             placeholder="Sélectionnez une Société"
                             :value="old('company', $contract->company_id)"
                             :error="$errors->first('company')"
                             :options="$companies"
                             readonly
                    />
                    <div class="flex gap-2.5">
                        <x-input type="select"
                                 name="type"
                                 label="Type"
                                 placeholder="Sélectionnez un Type de Contract"
                                 :options="$types"
                                 :value="old('type', $contract->type_id)"
                                 :error="$errors->first('type')"
                                 readonly
                                 class="w-full"
                        />
                        @once
                            @vite('resources/js/scripts/contract/typeSelect.js')
                        @endonce

                        <x-input type="select"
                                 name="status"
                                 label="Status"
                                 placeholder="-"
                                 :options="$statuses"
                                 :value="old('status', $contract->status_id)"
                                 :error="$errors->first('status')"
                                 readonly
                                 class="w-full"
                        />
                    </div>
                    <div class="flex gap-2.5">
                        <x-input type="date"
                                 name="start"
                                 label="Date de Début"
                                 :value="old('start', $contract->start_date->format('Y-m-d'))"
                                 :error="$errors->first('start')"
                                 readonly
                                 class="w-full"
                        />
                        <x-input type="date"
                                 name="end"
                                 label="Date de Fin"
                                 :value="old('end', $contract->end_date?->format('Y-m-d'))"
                                 :error="$errors->first('end')"
                                 readonly
                                 class="w-full"
                        />
                    </div>
                </x-form.part>

            </x-form>

            <x-contract.range :contract="$contract"/>

            <x-table :data="$contract->tickets()->paginate(5)"
                     :filter="false" :edit="true" error="Aucun Ticket lié">
                <h3 class="text-2xl/tight font-bold">Tickets Liés</h3>
            </x-table>

            <x-table :data="$contract->relatedContracts()->paginate(5)"
                     :filter="false" :edit="true" error="Aucun Contrat lié">
                <h3 class="text-2xl/tight font-bold">Contrats Liés</h3>
            </x-table>

        </x-page.content>

    </x-page.main>
</x-page.layout>
