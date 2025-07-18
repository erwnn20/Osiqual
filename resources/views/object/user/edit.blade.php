@php use Illuminate\Support\Facades\Auth; @endphp

@props([
    'user',

    'roles',
    'companies'
])

<x-page.layout title="Modification Utilisateur - Osiqual">
    <x-page.main>

        <x-navbar.get :user="Auth::user()"/>

        <x-page.content icon="user" title="Modification Utilisateur">

            <div>
                @if(!$user->active)
                    <x-card.notification class="mb-4" color="#DA3636">
                        <p>
                            <span class="font-semibold">{{ $user->login }}</span> est actuellement <span
                                class="italic">bloqué</span>
                        </p>

                        <x-form :action="route('user.unblock', ['id' => $user->id])" method="patch"
                                class="ms-auto">
                            <x-button type="submit" size="sm" icon="check" color="positive">
                                Déloquer l'utilisateur
                            </x-button>
                        </x-form>
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
                                         required
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
                                         required
                                         class="w-4/5"
                                />
                                <x-input type="select"
                                         name="role"
                                         label="Rôle"
                                         placeholder="Sélectionnez un Role"
                                         :value="old('role', $user->role_id)"
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
                            />
                            <x-input type="password"
                                     name="password_confirmation"
                                     label="Confirmer Mot de passe"
                                     placeholder="Confirmez le mot de passe..."
                                     :error="$errors->first('password_confirmation')"
                            />
                        </x-form.part>
                    </div>

                </x-form>

                @if($user->active)
                    <x-form :action="route('user.block', ['id' => $user->id])" method="patch">
                        <x-button type="submit" size="sm" icon="ban" color="negative" class="w-full mt-4">
                            Bloquer l'utilisateur
                        </x-button>
                    </x-form>
                @endif
            </div>

            <x-table :data="$user->tickets()->paginate(5)"
                     :filter="false" :edit="true" error="Aucun Ticket lié">
                <h3 class="text-2xl/tight font-bold">Tickets Liés</h3>
            </x-table>

        </x-page.content>

    </x-page.main>
</x-page.layout>
