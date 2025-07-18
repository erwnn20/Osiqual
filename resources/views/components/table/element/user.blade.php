@props([
    'head' => false,
    'company' => false,
    'link' => false,
    'user'
])

<x-table.element :head="$head" {{ $attributes }}>
    @if($user)
        <div class="flex gap-2 items-center">
            <span
                class="flex items-center justify-center h-8 w-8 rounded-full bg-primary/20 text-primary text-sm font-normal">
               {{ ($user->firstname ? $user->firstname[0] : '' ) . $user->lastname[0] }}
            </span>
            <div class="flex flex-col">
                <span @class(['text-sm/snug', 'font-semibold', 'text-default-700' => !$head])>
                    {{ ($user->firstname ? $user->firstname . ' ' : '' ) . $user->lastname }}
                </span>
                @if($company)
                    <span class="text-xs/tight font-normal text-default-500">
                        {{ $user->company->name }}
                    </span>
                @endif
            </div>
        </div>
    @else
        <span>-</span>
    @endif
</x-table.element>
