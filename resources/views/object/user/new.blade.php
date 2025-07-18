@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'roles',
    'companies'
])

<x-page.layout title="Creation Utilisateur - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="user" title="Creation Utilisateur">

            <x-form method="post">

                <x-form.part title="Informations" :submit="['text' => 'Créer', 'icon' => 'plus']">
                    <div class="flex gap-2.5">
                        <x-input type="text"
                                 name="firstname"
                                 label="Prénom"
                                 placeholder="Ex. : John"
                                 :value="old('firstname')"
                                 :error="$errors->first('firstname')"
                                 class="w-full"
                        />
                        <x-input type="text"
                                 name="lastname"
                                 label="Nom"
                                 placeholder="Ex. : Doe"
                                 :value="old('lastname')"
                                 :error="$errors->first('lastname')"
                                 required
                                 class="w-full"
                        />
                        <x-input type="text"
                                 name="login"
                                 label="Identifiant"
                                 placeholder="Ex. : jdoe"
                                 :value="old('login')"
                                 :error="$errors->first('login')"
                                 required
                                 class="min-w-44"
                        />
                    </div>
                    <div class="flex gap-2.5">
                        <x-input type="email"
                                 name="email"
                                 label="Email"
                                 placeholder="Ex. : john.doe@exemple.com"
                                 :value="old('email')"
                                 :error="$errors->first('email')"
                                 required
                                 class="w-5/6"
                        />
                        <x-input type="tel"
                                 name="phone"
                                 label="Téléphone"
                                 placeholder="Ex. : +33 6 12 34 56 78"
                                 :value="old('phone')"
                                 :error="$errors->first('phone')"
                                 class="w-1/6"
                        />
                    </div>
                    <div class="flex gap-2.5">
                        <x-input type="select"
                                 name="company"
                                 label="Société"
                                 placeholder="Sélectionnez une Société"
                                 :value="old('company')"
                                 :error="$errors->first('company')"
                                 :options="$companies"
                                 required
                                 class="w-4/5"
                        />
                        <x-input type="select"
                                 name="role"
                                 label="Rôle"
                                 placeholder="Sélectionnez un Role"
                                 :value="old('role')"
                                 :error="$errors->first('role')"
                                 :options="$roles"
                                 required
                                 class="w-1/5"
                        />
                    </div>
                    <x-input type="password"
                             name="password"
                             label="Mot de passe"
                             assistiveText="Règles de mot de passe (lettres, nombres, caractères spéciaux, ...)"
                             placeholder="Saisissez le mot de passe..."
                             :error="$errors->first('password')"
                             required
                    />
                    <x-input type="password"
                             name="password_confirmation"
                             label="Confirmer Mot de passe"
                             placeholder="Confirmez le mot de passe..."
                             :error="$errors->first('password_confirmation')"
                             required
                    />
                </x-form.part>

            </x-form>

        </x-page.content>

    </x-page.main>
</x-page.layout>
