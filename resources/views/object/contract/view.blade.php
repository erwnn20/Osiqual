@php use Illuminate\Support\Carbon;use Illuminate\Support\Facades\Auth; @endphp

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

                <div>
                    @if (session('success'))
                        <x-card.notification class="mb-4" color="#00B112">
                            {{ session('success') }}
                        </x-card.notification>
                    @endif

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

                            <div class="flex flex-col gap-1">
                                <p class="w-fit text-sm font-medium text-default-700">
                                    Status
                                </p>

                                <span class="w-full rounded-lg py-2 px-4
                                             <!--bg-default-200/70 text-default-800-->
                                             uppercase whitespace-nowrap font-semibold"
                                      style="background-color: {{ $contract->status->color }}26; color: {{ $contract->status->color }}">
                                    {{ $contract->status->name }}
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2.5">
                            @php
                                $value = old('start')
                                    ? Carbon::parse(old('start'))->format('Y-m-d')
                                    : $contract->start_date->format('Y-m-d');
                            @endphp
                            <x-input type="date"
                                     name="start"
                                     label="Date de Début"
                                     :value="$value"
                                     :error="$errors->first('start')"
                                     readonly
                                     class="w-full"
                            />
                            @php
                                $value = old('end')
                                    ? Carbon::parse(old('end'))->format('Y-m-d')
                                    : $contract->end_date?->format('Y-m-d');
                            @endphp
                            <x-input type="date"
                                     name="end"
                                     label="Date de Fin"
                                     :value="$value"
                                     :error="$errors->first('end')"
                                     readonly
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
