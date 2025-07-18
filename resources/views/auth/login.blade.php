<x-page.layout title="Connection - Osiqual">
    <main class="bg-primary w-full h-screen flex flex-row">

        <img
            class="w-1/2 shrink-0 object-cover"
            src="{{ asset('img/illustrative_image.png') }}"
            alt="illustrative image">

        <div class="w-1/2 flex items-center">
            <div class="bg-default-50 rounded-3xl flex flex-col gap-6 p-12 m-auto">

                <div class="flex items-center gap-2 mx-auto ">
                    <img class="h-14" src="{{ asset('img/logo.svg') }}" alt="Logo"/>
                    <h1 class="text-5xl font-bold text-default-800">Osiqual</h1>
                </div>

                <p class="text-default-600 text-pretty">Bienvenue ! Connectez vous pour acceder à la plateforme.</p>

                <form
                    action="{{ route('auth.login') }}" method="post"
                    class="flex flex-col gap-5">
                    @csrf

                    <x-input
                        type="text"
                        label="Identifiant"
                        name="login"
                        :value="old('login')"
                        placeholder="Entrez votre identifiant..."
                        :error="$errors->first('login')"
                    />
                    <x-input
                        label="Mot de passe"
                        name="password"
                        type="password"
                        placeholder="Mot de passe..."
                        :error="$errors->first('password')"
                    />

                    <x-button type="submit" class="w-full" size="md">Connection</x-button>

                </form>

            </div>
        </div>
    </main>
</x-page.layout>
