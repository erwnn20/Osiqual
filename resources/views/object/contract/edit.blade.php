@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'contract',

    'companies',
    'types',
    'statuses',
])

<x-page.layout title="Modification Contrat - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="file-text" title="Modification Contrat">

            <x-form method="patch">

                <div>
                    @if (session('success'))
                        <x-card.notification class="mb-4" color="#00B112">
                            {{ session('success') }}
                        </x-card.notification>
                    @endif

                    <x-form.part title="Informations" :submit="['text' => 'Enregister', 'icon' => 'save']">
                        <x-input type="select"
                                 name="company"
                                 label="Société"
                                 placeholder="Sélectionnez une Société"
                                 :options="$companies"
                                 :value="old('company', $contract->company_id)"
                                 :error="$errors->first('company')"
                                 readonly
                        />
                        <div class="flex gap-2.5">
                            <x-input type="select"
                                     name="type"
                                     label="Type"
                                     placeholder="Sélectionnez un Type de Contrat"
                                     :value="old('type', $contract->type_id)"
                                     :error="$errors->first('type')"
                                     :options="$types"
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
                                     :value="old('status', $contract->status_id)"
                                     :error="$errors->first('status')"
                                     :options="$statuses"
                                     required
                                     class="w-full"
                            />
                        </div>
                        <div class="flex gap-2.5">
                            <x-input type="date"
                                     name="start"
                                     label="Date de Début"
                                     :value="old('start', $contract->start_date->format('Y-m-d'))"
                                     :error="$errors->first('start')"
                                     required
                                     class="w-full"
                            />
                            <x-input type="date"
                                     name="end"
                                     label="Date de Fin"
                                     :value="old('end', $contract->end_date?->format('Y-m-d'))"
                                     :error="$errors->first('end')"
                                     required
                                     class="w-full"
                            />
                        </div>
                    </x-form.part>
                </div>

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
