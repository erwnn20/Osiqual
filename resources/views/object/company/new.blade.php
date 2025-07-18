@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'countries'
])

<x-page.layout title="Creation Société - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="building-2" title="Creation Société">

            <x-form method="post">

                <x-form.part title="Informations" :submit="['text' => 'Créer', 'icon' => 'plus']">
                    <x-input type="text"
                             name="name"
                             label="Nom de la Société"
                             placeholder="Ex. : Acme Corp"
                             :value="old('name')"
                             :error="$errors->first('name')"
                             required
                    />
                    <div class="flex gap-2.5">
                        <x-input type="text"
                                 name="address"
                                 label="Adresse"
                                 placeholder="Ex. : 123 rue de la République"
                                 :value="old('address')"
                                 :error="$errors->first('address')"
                                 required
                                 class="w-1/2"
                        />
                        <x-input type="number"
                                 name="zipcode"
                                 label="Code Postal"
                                 placeholder="Ex. : 75000"
                                 :value="old('zipcode')"
                                 :error="$errors->first('zipcode')"
                                 class="w-1/10"
                        />
                        <x-input type="text"
                                 name="city"
                                 label="Ville"
                                 placeholder="Ex. : Paris"
                                 :value="old('city')"
                                 :error="$errors->first('city')"
                                 required
                                 class="w-1/5"
                        />
                        <x-input type="select"
                                 name="country"
                                 label="Pays"
                                 placeholder="Sélectionnez un pays"
                                 :value="old('country')"
                                 :error="$errors->first('country')"
                                 :options="$countries"
                                 required
                                 class="w-1/5"
                        />
                    </div>
                    <x-input type="text"
                             name="siret"
                             label="SIRET"
                             placeholder="XXX XXX XXX XXXXX"
                             :value="old('siret')"
                             :error="$errors->first('siret')"
                             required
                             :max="17"
                    />
                </x-form.part>

            </x-form>

        </x-page.content>

    </x-page.main>
</x-page.layout>
