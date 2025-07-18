<x-page.layout>
    <x-page.main>

        <x-navbar.get :user="\App\Models\User::inRandomOrder()->first()"/>

        <x-page.content icon="house" title="Titre">

            <x-form method="get">

                <x-form.part>

                    <div class="flex gap-2.5">
                        <x-input class="w-full" type="text" name="value"
                                 label="Label : default avec valeur"
                                 assistiveText="default avec valeur"
                                 placeholder="Placeholder : default avec valeur"
                        />
                        {{--<x-input class="w-full" type="text" name="value"
                                 label="Label : default avec valeur"
                                 assistiveText="default avec valeur"
                                 placeholder="Placeholder : default avec valeur"

                                 :value="$value"

                                 autocomplete="off"
                        />--}}
                        <x-input type="color"
                                 name="test-null-error"
                                 label="Label : null + error"
                                 assistiveText="position = null + error"
                                 required
                                 error="Test d'erreur"
                                 class="w-1/3"
                        />
                    </div>

                    <x-input type="color"
                             name="test-null"
                             label="Label : null"
                             assistiveText="position = null"
                             required
                    />
                    <x-input type="color"
                             name="test-null-error"
                             label="Label : null + error"
                             assistiveText="position = null + error"
                             required
                             error="Test d'erreur"
                    />

                    <x-input type="color"
                             name="test-right"
                             label="Label : right"
                             assistiveText="position = right"
                             labelPosition="right"
                             required
                    />
                    <x-input type="color"
                             name="test-right-error"
                             label="Label : right + error"
                             assistiveText="position = right + error"
                             labelPosition="right"
                             required
                             error="Test d'erreur"
                    />

                    <x-input type="color"
                             name="test-top"
                             label="Label : top"
                             assistiveText="position = top"
                             labelPosition="top"
                             required
                    />
                    <x-input type="color"
                             name="test-top-error"
                             label="Label : top + error"
                             assistiveText="position = top + error"
                             labelPosition="top"
                             required
                             error="Test d'erreur"
                             class="w-full"
                    />
                    <x-input type="color"
                             name="test-top-error"
                             label="Label : top + error"
                             assistiveText="position = top + error"
                             labelPosition="top"
                             required
                             error="Test d'erreur"
                             class="w-1/5"
                    />

                </x-form.part>

                <x-form.part
                    {{--title="Test"--}} {{--:submit="['text' => 'Submit']"--}}>

                    @php $type = 'select' @endphp
                    @php $value = 'Test de valeur' @endphp

                    <div class="flex gap-2.5">
                        <x-input class="w-full" :type="$type" name="value"
                                 label="Label : default avec valeur"
                                 assistiveText="default avec valeur"
                                 placeholder="Placeholder : default avec valeur"

                                 :value="$value"
                                 :options="$opts"

                                 required
                                 readonly
                        />
                        {{--<x-input class="w-full" type="text" name="value"
                                 label="Label : default avec valeur"
                                 assistiveText="default avec valeur"
                                 placeholder="Placeholder : default avec valeur"

                                 :value="$value"

                                 autocomplete="off"
                        />--}}
                    </div>

                    <x-input :type="$type" name="value-error"
                             label="Label : default avec valeur + erreur"
                             assistiveText="Assistive : default avec valeur + erreur"
                             placeholder="Placeholder : default avec valeur + erreur"

                             :value="$value"
                             :options="$opts"
                             checked
                             error="Test d'erreur"

                             autocomplete="off"
                             readonly
                    />

                    <x-input :type="$type" name="error"
                             label="Label : default avec erreur"
                             assistiveText="Assistive : default avec erreur"
                             placeholder="Placeholder : default avec erreur"

                             error="Test d'erreur"

                             autocomplete="off"
                             readonly
                    />

                    <x-input :type="$type" name="disabled-value"
                             label="Label : disabled avec valeur"
                             assistiveText="disabled avec valeur"
                             placeholder="Placeholder : disabled avec valeur"

                             :value="$value"
                             :options="$opts"
                             checked
                             disabled

                             autocomplete="off"
                    />

                    <x-input :type="$type" name="disabled-value-error"
                             label="Label : disabled avec valeur + erreur"
                             assistiveText="Assistive : disabled avec valeur + erreur"
                             placeholder="Placeholder : disabled avec valeur + erreur"

                             :value="$value"
                             :options="$opts"
                             checked
                             error="Test d'erreur"
                             disabled

                             autocomplete="off"
                    />

                    <x-input :type="$type" name="disabled-error"
                             label="Label : disabled avec erreur"
                             assistiveText="Assistive : disabled avec erreur"
                             placeholder="Placeholder : disabled avec erreur"

                             error="Test d'erreur"
                             disabled

                             autocomplete="off"
                    />

                </x-form.part>

            </x-form>

        </x-page.content>

    </x-page.main>
</x-page.layout>
