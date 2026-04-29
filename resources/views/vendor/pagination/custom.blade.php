@if ($paginator->hasPages())
    <nav class="pagination-container" role="navigation" aria-label="Paginación">
        <p class="pagination-info">
            Mostrando {{ $paginator->firstItem() }} a {{ $paginator->lastItem() }} de {{ $paginator->total() }} resultados
        </p>

        <ul class="pagination-buttons">
            @if ($paginator->onFirstPage())
                <li>
                    <span class="pagination-disabled">Anterior</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link" rel="prev">
                        Anterior
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="pagination-disabled">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="pagination-active">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="pagination-link">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link" rel="next">
                        Siguiente
                    </a>
                </li>
            @else
                <li>
                    <span class="pagination-disabled">Siguiente</span>
                </li>
            @endif
        </ul>
    </nav>
@endif