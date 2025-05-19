@if ($paginator->hasPages())
    <div class="erp-pagination-wrapper d-flex justify-content-between align-items-center">
        <div class="erp-pagi-item">
            <div class="showing-date-box">
                <p>Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries</p>
            </div>
        </div>

        <div class="erp-pagi-item">
            <ul class="pagination">

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">«</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @if ($paginator->lastPage() <= 7)
                    {{-- Show all page numbers if total pages ≤ 7 --}}
                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        <li class="page-item {{ $i == $paginator->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                @else
                    {{-- If current page near beginning --}}
                    @if ($paginator->currentPage() <= 3)
                        @for ($i = 1; $i <= 4; $i++)
                            <li class="page-item {{ $i == $paginator->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage() - 1) }}">{{ $paginator->lastPage() - 1 }}</a></li>
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>

                    {{-- If current page near end --}}
                    @elseif ($paginator->currentPage() >= ($paginator->lastPage() - 2))
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url(2) }}">2</a></li>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        @for ($i = $paginator->lastPage() - 3; $i <= $paginator->lastPage(); $i++)
                            <li class="page-item {{ $i == $paginator->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                    {{-- If current page in the middle --}}
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        @for ($i = $paginator->currentPage() - 1; $i <= $paginator->currentPage() + 1; $i++)
                            <li class="page-item {{ $i == $paginator->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
                    @endif
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">»</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">»</span></li>
                @endif

            </ul>
        </div>
    </div>
@endif
