@if ($paginator->hasPages())
    <nav
        class="flex items-center flex-wrap justify-between"
        aria-label="Table navigation">

        <span class="text-sm text-default-500">
            Affichage de
            <span class="font-semibold text-default-800">{{ $paginator->firstItem() }}</span>
            @if($paginator->count() > 1)
                à
                <span class="font-semibold text-default-800">{{ $paginator->lastItem() }}</span>
            @endif
            sur
            <span class="font-semibold text-default-800">{{ $paginator->total() }}</span>
        </span>

        <ul class="inline-flex -space-x-px text-sm h-8 bg-default-50">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span
                        class="flex gap-1 items-center justify-center ps-2 pe-3 h-full text-default-300 border border-default-200 rounded-s-lg cursor-not-allowed">
                        <i class="w-fit py-1 stroke-2" data-lucide="chevron-left"></i>
                        Précédent
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="flex gap-1 items-center justify-center ps-2 pe-3 h-full text-default-500 border border-default-200 hover:bg-default-100 hover:text-default-700 rounded-s-lg">
                        <i class="w-fit py-1 stroke-2" data-lucide="chevron-left"></i>
                        Précédent
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="flex items-center justify-center px-3 h-full text-default-500"> {{ $element }} </span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span aria-current="page"
                                      class="flex items-center justify-center px-3 h-full text-primary bg-primary/5 border border-default-200 hover:bg-primary/10 hover:font-semibold">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="flex items-center justify-center px-3 h-full text-default-500 border border-default-200 hover:bg-default-100 hover:text-default-700">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="flex gap-1 items-center justify-center ps-3 pe-2 h-full text-default-500 border border-default-200 hover:bg-default-100 hover:text-default-700 rounded-e-lg">
                        Suivant
                        <i class="w-fit py-1 stroke-2" data-lucide="chevron-right"></i>
                    </a>
                </li>
            @else
                <li>
                    <span
                        class="flex gap-1 items-center justify-center ps-3 pe-2 h-full text-default-300 border border-default-200 rounded-e-lg cursor-not-allowed">
                        Suivant
                        <i class="w-fit py-1 stroke-2" data-lucide="chevron-right"></i>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
