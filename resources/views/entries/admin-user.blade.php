<div class="p-3 my-3 border border-gray-200 bg-white rounded">
    <div class="text-2xs text-muted text-truncate">{{ preg_replace('/{uuid}/', request('uuid'), $entry->links[0]->url) }}</div>
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ preg_replace('/{uuid}/', request('uuid'), $entry->links[0]->url) }}" class="text-lg">
            [{{ $entry->docType }}] {{ $entry->name }}
        </a>
        @include('search::partials.score')
    </div>
    @include('search::partials.preview')
</div>
