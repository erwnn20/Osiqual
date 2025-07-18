@php use Illuminate\Support\Facades\Route; @endphp

@props([
    'user'
])

<nav class="bg-default-50 rounded-2xl shadow-xl
            my-9 px-5 pt-12 pb-8 w-xs sticky top-9
            flex flex-col">

    <!-- Top -->
    <div class="flex gap-2 items-center mb-12">
        <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="h-8"/>
        <h1 class="text-xl font-bold">Osiqual</h1>
    </div>

    <!-- Actions and nav -->
    <div class="flex flex-col gap-2 border-b border-b-default-200 pb-2">
        <x-button class="w-full " :href="route('ticket.new')" icon="plus" size="sm">
            Nouveau Ticket
        </x-button>
        <x-navbar.element.link :href="route('index')" icon="house"
                               :active="Route::currentRouteName() === 'index'"
                               class="">
            Dashboard
        </x-navbar.element.link>
    </div>

    <!-- Slot scrollable -->
    <div id="scrollable"
         class="flex flex-col h-full gap-2 overflow-y-auto"
         style="scrollbar-width: thin;">
        {{ $slot }}
    </div>

    <!-- Footer user -->
    <div class="border-t border-t-default-200 pt-4 flex gap-1 justify-between items-center">
        <a href="{{ route('user.self') }}" class="flex gap-2 items-center">
            <span class="flex items-center justify-center h-8 w-8 rounded-full bg-primary/20 text-primary text-sm">
                {{ ($user->firstname ? $user->firstname[0] : '' ) . $user->lastname[0] }}
            </span>
            <div class="flex flex-col">
                <span class="text-sm/snug font-semibold">
                    {{ ($user->firstname ? $user->firstname . ' ' : '' ) . $user->lastname }}
                </span>
                <span class="text-xs/tight text-default-500">{{ $user->company->name }}</span>
            </div>
        </a>
        <form action="{{ route('auth.logout') }}" method="post" class="h-full flex items-center">
            @method('delete')
            @csrf
            <button type="submit" class="cursor-pointer">
                <i class="h-5 text-red-700" data-lucide="log-out"></i>
            </button>
        </form>
    </div>
</nav>
