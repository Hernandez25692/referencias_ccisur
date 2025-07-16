@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded cursor-not-allowed">Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-1 bg-white text-gray-700 hover:bg-blue-50 border rounded">Anterior</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-500">…</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if (
                        $page >= $paginator->currentPage() - 2 &&
                        $page <= $paginator->currentPage() + 2
                    )
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 text-white bg-[#002c5f] rounded">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                               class="px-3 py-1 bg-white text-gray-700 hover:bg-blue-50 border rounded">{{ $page }}</a>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-1 bg-white text-gray-700 hover:bg-blue-50 border rounded">Siguiente</a>
        @else
            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded cursor-not-allowed">Siguiente</span>
        @endif
    </nav>
@endif
