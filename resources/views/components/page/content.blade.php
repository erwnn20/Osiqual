@props([
    'title',
    'icon' => null,
])

<div class="relative mx-12 my-9 h-fit w-full">

    <!-- theme select -->
    <div class="absolute top-0 right-0">
        <label id="theme-toggle" class="relative inline-block w-12 h-7 mx-auto">
            <input id="theme-input" type="checkbox" class="peer opacity-0 w-0 h-0"/>

            <!-- slider -->
            <span class="absolute cursor-pointer top-0 left-0 right-0 bottom-0 inset-shadow-sm
                             bg-default-200 rounded-full transition peer-checked:bg-default-300
                             peer-focus:ring-2 peer-focus:ring-primary/50">
                </span>

            <!-- circle -->
            <span class="absolute top-1 left-1 w-5 h-5
                             flex justify-center items-center
                             bg-default-50 rounded-full shadow-sm
                             transition peer-checked:translate-x-5">
                    <i class="h-3.5 text-default-600" data-lucide="sun-medium"></i>
                    <i class="h-3.5 text-default-600 hidden" data-lucide="moon"></i>
                </span>
        </label>

        @once
            @push('scripts')
                <script>
                    const themeContainer = document.getElementById('theme-toggle');
                    const themeToggle = themeContainer.querySelector('input');
                    const iconLight = themeContainer.querySelector('[data-lucide="sun-medium"]');
                    const iconDark = themeContainer.querySelector('[data-lucide="moon"]');

                    function setDark() {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                        iconLight.classList.add('hidden');
                        iconDark.classList.remove('hidden');
                    }

                    function setLight() {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                        iconDark.classList.add('hidden');
                        iconLight.classList.remove('hidden');
                    }

                    document.addEventListener('DOMContentLoaded', () => {
                        if (localStorage.getItem('theme') === 'dark') {
                            setDark();
                            themeToggle.checked = true;
                        }
                    });

                    themeToggle.addEventListener('change', () => {
                        if (themeToggle.checked) setDark()
                        else setLight()
                    });
                </script>
            @endpush
        @endonce
    </div>

    <header class="mt-14 mb-16 flex gap-2.5 items-center h-14">
        @if($icon)
            <i class="h-full w-fit" data-lucide="{{ $icon }}"></i>
        @endif
        <h1 class="py-1 text-5xl font-bold">{{ $title }}</h1>
    </header>
    <div class="flex flex-col gap-14 ">
        {{ $slot }}
    </div>
</div>
