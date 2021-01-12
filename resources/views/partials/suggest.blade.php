<div class="py-2">Peut-être recherchiez-vous <a href="{{ route('search.submit', ['uuid' => request('uuid'), 'searchword' => $suggestions[0]->name]) }}">
        {{ $suggestions[0]->name }} [{{ $suggestions[0]->docType }}]</a>&nbsp;?
</div>
