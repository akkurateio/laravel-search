<nav class="w-100">
    <ul class="pagination d-flex w-100">
        {{-- Previous Page Link --}}
        @if($current == 1)
            <li class="d-none" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link rounded-full text-xs-2xs text-lg-md font-bold px-3 py-2 px-md-4 py-md-3"
                          aria-hidden="true">⟵</span>
            </li>
        @else
            <li class="page-item mr-1 mr-sm-2">
                <a class="page-link rounded-full text-xs-2xs text-lg-md font-bold px-3 py-2 px-md-4 py-md-3"
                   href="{{ URL::current() }}?from={{ $before }}" rel="prev"
                   aria-label="@lang('pagination.previous')">⟵</a>
            </li>
        @endif

        @if(agent()->isDesktop() && $pages <= 5)
            {{-- Pagination Elements --}}
            @for ($i = 1; $i <= $pages; $i++)
                @if ($i == $current)
                    <li class="page-item mr-1 mr-sm-2 active" aria-current="page">
                        <span class="page-link rounded-full text-xs-2xs text-lg-md font-bold px-3 py-2 px-md-4 py-md-3">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item mr-1 mr-sm-2">
                        <a class="page-link rounded-full text-xs-2xs text-lg-md font-bold px-3 py-2 px-md-4 py-md-3"
                           href="{{ URL::current() }}?from={{ config('laravel-search.pagination') * $i - config('laravel-search.pagination') }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor
        @endif

        {{-- Next Page Link --}}
        @if($current < $pages)
            <li class="page-item ml-auto">
                <a class="page-link rounded-full text-xs-2xs text-lg-md font-bold px-3 py-2 px-md-4 py-md-3"
                   href="{{ URL::current() }}?from={{ $from }}" rel="next"
                   aria-label="{{ __('Voir la suite') }}">
                    {{ __('Voir la suite') }}
                </a>
            </li>
        @endif
    </ul>
</nav>
