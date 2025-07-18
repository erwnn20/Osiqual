@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'user',

    'roles',
    'companies'
])

<x-page.layout title="Votre Profil - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="user" title="Votre Profil">

            <div>
                @if(!$user->active)
                    <x-card.notification class="mb-4" color="#DA3636">
                        <p>
                            <span class="font-semibold">{{ $user->login }}</span> est actuellement <span
                                class="italic">bloqué</span>
                        </p>
                    </x-card.notification>
                @endif

                <x-form method="patch">

                    <div>
                        @if (session('success'))
                            <x-card.notification class="mb-4" color="#00B112">
                                {{ session('success') }}
                            </x-card.notification>
                        @endif

                        <x-form.part title="Informations" :submit="['text' => 'Enregister', 'icon' => 'save']">
                            <div class="flex gap-2.5">
                                <x-input type="text"
                                         name="firstname"
                                         label="Prénom"
                                         placeholder="Ex. : John"
                                         :value="old('firstname', $user->firstname)"
                                         :error="$errors->first('firstname')"
                                         class="w-full"
                                />
                                <x-input type="text"
                                         name="lastname"
                                         label="Nom"
                                         placeholder="Ex. : Doe"
                                         :value="old('lastname', $user->lastname)"
                                         :error="$errors->first('lastname')"
                                         required
                                         class="w-full"
                                />
                                <x-input type="text"
                                         name="login"
                                         label="Identifiant"
                                         placeholder="Ex. : jdoe"
                                         :value="old('login', $user->login)"
                                         :error="$errors->first('login')"
                                         readonly
                                         class="min-w-44"
                                />
                            </div>
                            <div class="flex gap-2.5">
                                <x-input type="email"
                                         name="email"
                                         label="Email"
                                         placeholder="Ex. : john.doe@exemple.com"
                                         :value="old('email', $user->email)"
                                         :error="$errors->first('email')"
                                         required
                                         class="w-5/6"
                                />
                                <x-input type="tel"
                                         name="phone"
                                         label="Téléphone"
                                         placeholder="Ex. : +33 6 12 34 56 78"
                                         :value="old('phone', $user->phone)"
                                         :error="$errors->first('phone')"
                                         class="w-1/6"
                                />
                            </div>
                            <div class="flex gap-2.5">
                                <x-input type="select"
                                         name="company"
                                         label="Société"
                                         placeholder="Sélectionnez une Société"
                                         :value="old('company', $user->company_id)"
                                         :error="$errors->first('company')"
                                         :options="$companies"
                                         readonly
                                         class="w-4/5"
                                />
                                <x-input type="select"
                                         name="role"
                                         label="Rôle"
                                         placeholder="Sélectionnez un Role"
                                         :value="old('role', $user->role_id)"
                                         :error="$errors->first('role')"
                                         :options="$roles"
                                         readonly
                                         class="w-1/5"
                                />
                            </div>
                            <x-input type="password"
                                     name="password"
                                     label="Nouveau Mot de passe"
                                     assistiveText="Règles de mot de passe (lettres, nombres, caractères spéciaux, ...)"
                                     placeholder="Saisissez votre nouveau mot de passe..."
                                     :error="$errors->first('password')"
                            />
                            <x-input type="password"
                                     name="password_confirmation "
                                     label="Confirmer Mot de passe"
                                     placeholder="Confirmez le mot de passe..."
                                     :error="$errors->first('password_confirmation')"
                            />
                        </x-form.part>
                    </div>

                </x-form>
            </div>

            <x-table :data="$user->tickets()->paginate(5)"
                     :filter="false" :edit="true" error="Vous n'avez aucun Ticket">
                <h3 class="text-2xl/tight font-bold">Vos Tickets</h3>
            </x-table>

        </x-page.content>

    </x-page.main>
</x-page.layout>
