@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Recherche',
        'route' => 'brain',
        'package' => ' ',
        'label' => __(' ')
    ])
    @endcomponent
@stop

@section('content')
    @component('back::atomicdesign.moleculs.body-right', [
])
        @slot('body')
            <div class="inner">
                <div class="md-4">
                    <div class="text-xl font-bold">Résultats de votre recherche</div>
                    <div class="d-flex justify-content-between">
                        <p>Mot-clé(s) recherché(s) : <span class="font-bold">{{ request('query') }}</span></p>
                        @if(!empty($searchResults))
                            <div>{{ $searchResults->count() }} résultat<span>@if($searchResults->count() > 1)s @endif</span></div>
                        @endif
                    </div>
                </div>
                @if($searchResults->count() === 0)
                    <div class="py-5 text-muted text-center">Votre recherche ne donne aucun résultat !</div>
                @else
                    <div>
                        @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                            <div class="">
                                @foreach($modelSearchResults as $searchResult)
                                    @if(View::exists('search::entries.' . Str::singular(Str::slug($type))))
                                        @include('search::entries.' . Str::singular(Str::slug($type)), ['entry' => $searchResult])
                                    @else
                                        @include('search::entries.default', ['entry' => $searchResult])
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endslot
    @endcomponent

@endsection

