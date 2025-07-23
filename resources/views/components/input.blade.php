@props([
    'name',
    'type',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'assistiveText' => null,
    'error' => null,
    'title' => null,
    'data' => [],

    'autocomplete' => false,
    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,

    'spellcheck' => true, /* text, search, textarea */
    'minlength' => null, /* text, password, email, search, tel, url, textarea */
    'maxlength' => null, /* text, password, email, search, tel, url, textarea */
    'pattern' => null, /* text, password, email, search, tel, url */
    'size' => null, /* text, password, email, search, tel, url, button, select */
    'multiple' => false, /* email, file, select */
    'min' => null, /* number, range, datetime */
    'max' => null, /* number, range, datetime */
    'step' => null, /* number, range, datetime */
    'checked' => null, /* checkbox, radio */
    'icon' => null, /* button */
    'color' => null, /* button */
    'accept' => null, /* file */
    'webkitdirectory' => false, /* file */
    'options' => [], /* select */
    'wrap' => null, /* textarea */
    'labelPosition' => null, /* color */
    'warning' => true, /* default */
])

@switch($type)

    @case('text')
        <x-input.text
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :spellcheck="$spellcheck"
            :minlength="$minlength"
            :maxlength="$maxlength"
            :pattern="$pattern"
            :size="$size"

            {{ $attributes }}
        />
        @break

    @case('password')
        <x-input.password
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :minlength="$minlength"
            :maxlength="$maxlength"
            :pattern="$pattern"
            :size="$size"

            {{ $attributes }}
        />
        @break

    @case('email')
        <x-input.email
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :minlength="$minlength"
            :maxlength="$maxlength"
            :pattern="$pattern"
            :size="$size"
            :multiple="$multiple"

            {{ $attributes }}
        />
        @break

    @case('search')
        <x-input.search
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :spellcheck="$spellcheck"
            :minlength="$minlength"
            :maxlength="$maxlength"
            :pattern="$pattern"
            :size="$size"

            {{ $attributes }}
        />
        @break

    @case('tel')
        <x-input.tel
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :minlength="$minlength"
            :maxlength="$maxlength"
            :pattern="$pattern"
            :size="$size"

            {{ $attributes }}
        />
        @break

    @case('url')
        <x-input.url
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :minlength="$minlength"
            :maxlength="$maxlength"
            :pattern="$pattern"
            :size="$size"

            {{ $attributes }}
        />
        @break

    @case('number')
        <x-input.number
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :min="$min"
            :max="$max"
            :step="$step"

            {{ $attributes }}
        />
        @break

    @case('range')
        <x-input.range
            :name="$name"
            :label="$label"
            :value="$value ?? $placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :min="$min"
            :max="$max"
            :step="$step"

            {{ $attributes }}
        />
        @break

    @case('date')
    @case('month')
    @case('week')
    @case('time')
    @case('datetime-local')
        <x-input.datetime
            :type="$type"
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :min="$min"
            :max="$max"
            :step="$step"

            {{ $attributes }}
        />
        @break

    @case('color')
        <x-input.color
            :name="$name"
            :label="$label"
            :value="$value ?? $placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :labelPosition="$labelPosition"

            {{ $attributes }}
        />
        @break

    @case('checkbox')
        <x-input.checkbox
            :name="$name"
            :label="$label"
            :value="$value"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :checked="$checked"

            {{ $attributes }}
        />
        @break

    @case('radio')
        <x-input.radio
            :name="$name"
            :label="$label"
            :value="$value"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :checked="$checked"

            {{ $attributes }}
        />
        @break

    @case('hidden')
        <x-input.hidden
            :name="$name"
            :label="$label"
            :value="$value"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            {{ $attributes }}
        />
        @break

    @case('button')
    @case('submit')
    @case('reset')
        <x-input.button
            :type="$type"
            :name="$name"
            :label="$label"
            :value="$value"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autofocus="$autofocus"
            :disabled="$disabled"

            :icon="$icon"
            :size="$size"
            :color="$error ? 'negative' : $color"

            {{ $attributes }}
        />
        @break

    @case('file')
        <x-input.file
            :name="$name"
            :label="$label"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :multiple="$multiple"
            :accept="$accept"
            :webkitdirectory="$webkitdirectory"

            {{ $attributes }}
        />
        @break

    @case('select')
        <x-input.select
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :size="$size"
            :multiple="$multiple"
            :options="$options"

            {{ $attributes }}
        />
        @break

    @case('textarea')
        <x-input.textarea
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :spellcheck="$spellcheck"
            :minlength="$minlength"
            :maxlength="$maxlength"
            :wrap="$wrap"

            {{ $attributes }}
        />
        @break

    @default
        <x-input.default
            :type="$type"
            :name="$name"
            :label="$label"
            :value="$value"
            :placeholder="$placeholder"
            :assistiveText="$assistiveText"
            :error="$error"
            :title="$title"
            :data="$data"

            :autocomplete="$autocomplete"
            :autofocus="$autofocus"
            :disabled="$disabled"
            :readonly="$readonly"
            :required="$required"

            :warning="$warning"

            {{ $attributes }}
        />
        @break

@endswitch
