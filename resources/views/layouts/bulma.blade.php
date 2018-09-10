@if ($paginator->hasPages())
    <nav class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="pagination-previous" disabled aria-disabled="true" aria-label="@lang('pagination.previous')">
                Previous
            </a>
        @else
            
            <a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Previous</a>
            
        @endif
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            
            <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</a>
            
        @else
            <a class="pagination-next disabled" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</a>
        @endif
        <ul class="pagination-list">
            
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="pagination-ellipsis" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="pagination-link is-current" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="pagination-link"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        
        </ul>
    </nav>
@endif
