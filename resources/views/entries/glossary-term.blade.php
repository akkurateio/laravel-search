<div class="py-3">
    <div class="text-2xs text-muted text-truncate">{{ preg_replace('/{uuid}/', request('uuid'), $entry->links[0]->url) }}</div>
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ preg_replace('/{uuid}/', request('uuid'), $entry->links[0]->url) }}" class="text-lg">
            [{{ $entry->docType }}] {{ $entry->name }}
        </a>
        @include('search::partials.score')
    </div>
    @include('search::partials.preview')
</div>
