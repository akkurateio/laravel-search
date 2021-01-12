<div class="p-3 my-3 border border-gray-200 bg-white rounded">
    <div class="text-2xs text-muted text-truncate">{{ $entry->url }}</div>
    <div class="mb-2">
        <a href="{{ $entry->url }}" class="text-lg">
            [{{ Str::singular(Str::upper($entry->type)) }}] {{ $entry->title }}
        </a>
    </div>
</div>
