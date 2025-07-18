@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'user',

    'roles',
    'companies'
])

<x-page.layout title="Visualisation Utilisateur - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="user" title="Visualisation Utilisateur">

            <div>
                @if(!$user->active)
                    <x-card.notification class="mb-4" color="#DA3636">
                        <p>
                            <span class="font-semibold">{{ $user->login }}</span> est actuellement <span
                                class="italic">bloqué</span>
                        </p>
                    </x-card.notification>
                @endif

                <x-form method="post">

                    <x-form.part title="Informations">
                        <div class="flex gap-2.5">
                            <x-input type="text"
                                     name="firstname"
                                     label="Prénom"
                                     placeholder="Ex. : John"
                                     :value="old('firstname', $user->firstname)"
                                     :error="$errors->first('firstname')"
                                     readonly
                                     class="w-full"
                            />
                            <x-input type="text"
                                     name="lastname"
                                     label="Nom"
                                     placeholder="Ex. : Doe"
                                     :value="old('lastname', $user->lastname)"
                                     :error="$errors->first('lastname')"
                                     readonly
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
                                     readonly
                                     class="w-5/6"
                            />
                            <div class="flex gap-1.5 items-end-safe w-1/6">
                                {{--<x-input class="w-24" type="select" name="prefix-phone"
                                         label="Téléphone" placeholder="+ 33"
                                         :value="old('prefix-phone')" :error="$errors->first('prefix-phone')" readonly/>--}}
                                <x-input type="tel"
                                         name="phone"
                                         label="Téléphone"
                                         placeholder="Ex. : +33 6 12 34 56 78"
                                         :value="old('phone', $user->phone)"
                                         :error="$errors->first('phone')"
                                         readonly
                                         class="w-full"
                                />
                            </div>
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
                                     :options="$roles"
                                     :value="old('role', $user->role_id)"
                                     :error="$errors->first('role')"
                                     readonly
                                     class="w-1/5"
                            />
                        </div>
                    </x-form.part>

                </x-form>
            </div>

            <x-table :data="$user->tickets()->paginate(5)"
                     :filter="false" :edit="false" error="Aucun Ticket lié">
                <h3 class="text-2xl/tight font-bold">Tickets Liés</h3>
            </x-table>

        </x-page.content>

    </x-page.main>
</x-page.layout>
