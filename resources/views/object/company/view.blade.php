@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'company',

    'countries'
])

<x-page.layout title="Visualisation Société - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="building-2" title="Visualisation Société">

            <x-form method="post">

                <x-form.part title="Informations">
                    <x-input type="text"
                             name="name"
                             label="Nom de la Société"
                             placeholder="Ex. : Acme Corp"
                             :value="old('name', $company->name)"
                             :error="$errors->first('name')"
                             readonly
                    />
                    <div class="flex gap-2.5">
                        <x-input type="text"
                                 name="address"
                                 label="Adresse"
                                 placeholder="Ex. : 123 rue de la République"
                                 :value="old('address', $company->address)"
                                 :error="$errors->first('address')"
                                 readonly
                                 class="w-1/2"
                        />
                        <x-input type="number"
                                 name="zipcode"
                                 label="Code Postal"
                                 placeholder="Ex. : 75000"
                                 :value="old('zipcode', $company->zipcode)"
                                 :error="$errors->first('zipcode')"
                                 readonly
                                 class="w-1/10"
                        />
                        <x-input type="text"
                                 name="city"
                                 label="Ville"
                                 placeholder="Ex. : Paris"
                                 :value="old('city', $company->city)"
                                 :error="$errors->first('city')"
                                 readonly
                                 class="w-1/5"
                        />
                        <x-input type="select"
                                 name="country"
                                 label="Pays"
                                 placeholder="Sélectionnez un pays"
                                 :value="old('country', $company->country)"
                                 :error="$errors->first('country')"
                                 :options="$countries"
                                 readonly
                                 class="w-1/5"
                        />
                    </div>
                    <x-input type="text"
                             name="siret"
                             label="SIRET"
                             placeholder="XXX XXX XXX XXXXX"
                             :value="old('siret', $company->siret)"
                             :error="$errors->first('siret')"
                             readonly
                    />
                </x-form.part>

            </x-form>

            <x-table :data="$company->tickets()->paginate(perPage: 4, pageName: 'tickets_page')"
                     :filter="false" :edit="true" error="Aucun Ticket lié">
                <h3 class="text-2xl/tight font-bold">Tickets Liés</h3>
            </x-table>

            <div class="flex flex-col gap-3.5">
                <h3 class="text-2xl/tight font-bold">Contrats Liés</h3>

                @php $current = $company->currentContract() @endphp
                <x-table :data="collect([$current])->filter()"
                         :filter="false" :edit="false" error="Aucun Contrat en cours">
                    <h3 class="text-lg/tight font-bold">Contrat en cours</h3>
                </x-table>

                <x-table :data="$company->contracts()->where('id', '!=', $current?->id)
                                    ->paginate(perPage: 4, pageName: 'contracts_page')"
                         :filter="false" :edit="false" error="Aucun {{ $current ? 'autre ' : '' }}Contrats lié">
                    <h3 class="text-lg/tight font-bold">Autres Contrats</h3>
                </x-table>
            </div>

            <x-table :data="$company->employees()->paginate(perPage: 4, pageName: 'employees_page')"
                     :filter="false" :edit="false" error="Aucun Employé enregistré">
                <h3 class="text-2xl/tight font-bold">Employés</h3>
            </x-table>

        </x-page.content>

    </x-page.main>
</x-page.layout>
