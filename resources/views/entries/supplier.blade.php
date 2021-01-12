<div class="mb-3">
    <div class="row">
        <div class="col-1">
            <icon class="d-flex align-items-center h-100" name="Industry"></icon>
        </div>
        <div class="col-9">
            <div class="text-3xs text-neutral">Ressources -> Fournisseurs</div>
            @if (empty(request('filters')))
                <a href="{{ route('search.submit',
                        [
                            'uuid' => request('uuid'),
                            'searchword' => $keyword,
                            'filters' => '?filters[fields.supplier.uuid]=' . $entry->fields->uuid,
                        ]) }}" class="font-bold">
                    {{$entry->name}}
                </a>
            @else
                <a href="{{ route('search.submit',
                        [
                            'uuid' => request('uuid'),
                            'searchword' => $keyword,
                            'filters' => '&filters[fields.supplier.uuid]=' . $entry->fields->uuid
                        ]) }}" class="font-bold">
                    {{$entry->name}}
                </a>
            @endif
            <div class="text-3xs text-neutral">SIREN : {{ $entry->content[1] ?? 'Indéfini' }}</div>
        </div>
    </div>
</div>
