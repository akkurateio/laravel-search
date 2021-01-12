@if(isset($entry->url))
    <div class="text-2xs text-muted text-truncate">{{ $entry->url }}</div>
    <div class="mb-2">
        <a href="{{ $entry->url }}" class="text-lg">
            [{{ Str::singular(Str::upper($entry->type)) }}] {{ $entry->title }}
        </a>
    </div>
@else
    <div>
        <a href="{{preg_replace('/{uuid}/', request('uuid'), $entry->links[0]->url)}}">
            [{{$entry->docType}}] {{$result->name}}
        </a>
    </div>
@endif