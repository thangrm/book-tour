@if ($paginator->hasPages())
    <div class="pagination-tours d-flex justify-content-end align-items-baseline w-100">
        <div class="pagination-text">Showing {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</div>
        <nav class="page-navigation " aria-label="page navigation">
            <ul class="pagination justify-content-end">
                @if ($paginator->onFirstPage())
                    <li class="page-item ms-0">
                        <a class="page-link disabled" href="javascript:void(0)" tabindex="-1"
                           aria-disabled="true">
                            <img src="{{ asset('images/icon/arrow-pagination-left.svg') }}" alt="page-prev">
                        </a>
                    </li>
                @else
                    <li class="page-item ms-0">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1"
                           aria-disabled="true">
                            <img src="{{ asset('images/icon/arrow-pagination-left.svg') }}" alt="page-prev">
                        </a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item page-number active">
                                    <a class="page-link" href="#">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item page-number">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item me-0">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                            <img src="{{ asset('images/icon/arrow-pagination-right.svg') }}" alt="page-next">
                        </a>
                    </li>
                @else
                    <li class="page-item me-0">
                        <a class="page-link" href="javascript:void(0)">
                            <img src="{{ asset('images/icon/arrow-pagination-right.svg') }}" alt="page-next">
                        </a>
                    </li>
                @endif

            </ul>
        </nav>
    </div>
@endif
