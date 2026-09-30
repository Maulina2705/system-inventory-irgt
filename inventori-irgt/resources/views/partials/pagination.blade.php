@if ($paginator->hasPages())
    <div class="custom-pagination-container">
        {{-- Information text --}}
        <div class="pagination-info-text">
            Menampilkan <span>{{ $paginator->firstItem() }}</span> – <span>{{ $paginator->lastItem() }}</span> dari <span>{{ $paginator->total() }}</span> data
        </div>

        {{-- Page Buttons --}}
        <nav role="navigation" aria-label="Pagination Navigation" class="pagination-nav-wrap">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn pagination-disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    <span class="btn-text">Sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-btn" aria-label="@lang('pagination.previous')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    <span class="btn-text">Sebelumnya</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="pagination-numbers">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="pagination-dots" aria-disabled="true">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="pagination-num active" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pagination-num">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-btn" aria-label="@lang('pagination.next')">
                    <span class="btn-text">Berikutnya</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            @else
                <span class="pagination-btn pagination-disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="btn-text">Berikutnya</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            @endif
        </nav>
    </div>
@else
    <div class="custom-pagination-container" style="justify-content: flex-end;">
        <div class="pagination-info-text">
            Menampilkan seluruh <span>{{ $paginator->total() }}</span> data
        </div>
    </div>
@endif

<style>
.custom-pagination-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 16px 20px;
    background: #fff;
    border-top: 1px solid #f0f9ff;
    flex-wrap: wrap;
}
.pagination-info-text {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
}
.pagination-info-text span {
    color: #0c1a2e;
    font-weight: 700;
}
.pagination-nav-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
}
.pagination-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 12px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    color: #0369a1;
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    text-decoration: none;
    transition: all 0.15s ease;
    cursor: pointer;
    min-height: 34px;
}
.pagination-btn:hover:not(.pagination-disabled) {
    background: #0369a1;
    color: #fff;
    border-color: #0369a1;
}
.pagination-disabled {
    opacity: 0.45;
    cursor: not-allowed;
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #94a3b8;
}
.pagination-numbers {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.pagination-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 6px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #475569;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    text-decoration: none;
    transition: all 0.15s ease;
}
.pagination-num:hover:not(.active) {
    background: #e0f2fe;
    color: #0369a1;
    border-color: #bae6fd;
}
.pagination-num.active {
    background: linear-gradient(135deg, #0ea5e9, #0369a1);
    color: #fff;
    border-color: #0369a1;
    box-shadow: 0 2px 8px rgba(3,105,161,0.25);
}
.pagination-dots {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 34px;
    font-size: 14px;
    color: #94a3b8;
}

@media (max-width: 640px) {
    .custom-pagination-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 12px;
        padding: 14px 12px;
    }
    .pagination-nav-wrap {
        width: 100%;
        justify-content: space-between;
    }
    .pagination-btn .btn-text {
        display: none;
    }
    .pagination-btn {
        padding: 7px 10px;
        min-width: 36px;
        justify-content: center;
    }
    .pagination-num {
        min-width: 32px;
        height: 32px;
        font-size: 12px;
    }
}
</style>
