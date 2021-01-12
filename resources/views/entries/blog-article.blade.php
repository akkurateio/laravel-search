<div class="{{ $wrapperClass ?? 'my-3' }}">
    @if(isset($entry->url))
        <div class="text-2xs text-muted text-truncate">{{ $entry->url }}</div>
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ $entry->url }}" class="text-lg">
                [{{ Str::singular(Str::upper($entry->type)) }}] {{ $entry->title }}
            </a>
        </div>
    @else
        <div class="text-2xs text-muted text-truncate">{{ preg_replace('/{uuid}/', request('uuid'), $entry->links[0]->url) }}</div>
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ preg_replace('/{uuid}/', request('uuid'), $entry->links[0]->url) }}" class="text-lg">
                [{{ $entry->docType }}] {{ $entry->name }}
            </a>
            @include('search::partials.score')
        </div>
        @include('search::partials.preview')
    @endif
</div>
