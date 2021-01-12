@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Recherche',
        'route' => 'admin',
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
                        @if(!empty($keyword))
                            <p>Mot-clé(s) recherché(s) : <span class="font-bold">{{ $keyword }}</span></p>
                        @endif
{{--                        @if(!empty($filters))--}}
{{--                            <pre>@json($filters)</pre>--}}
{{--                        @endif--}}
                        @if(!empty($results))
                            <div>{{ $total }} résultat<span>@if($total > 1)s @endif</span></div>
                        @endif
                    </div>
                    @if(!empty($suggestions))
                        @include('search::partials.suggest')
                    @endif
                </div>
                @if(empty($results))
                    <div class="py-5 text-muted text-center">Votre recherche ne donne aucun résultat !</div>
                @else
                    <div class="mb-4">
                        @foreach($results as $result)
                            @if(View::exists('search::entries.' . Str::slug($result->docType)))
                                @include('search::entries.' . Str::slug($result->docType), ['entry' => $result])
                            @else
                                @include('search::entries.default', ['entry' => $result])
                            @endif
                        @endforeach
                    </div>
                @endif
                @if($total > config('laravel-search.pagination'))
                    @include('search::partials.pagination')
                @endif
            </div>
        @endslot
        @slot('right')
            <div class="inner">
                <div class="text-xl font-bold mb-4">Suggestions</div>
                @if(empty($suggestions))
                    <div class="py-5 text-muted text-center">Aucune suggestion</div>
                @else
                    @foreach($suggestions as $result)
                        @if(View::exists('search::entries.' . Str::slug($result->docType)))
                            @include('search::entries.' . Str::slug($result->docType), ['entry' => $result, 'keyword' => $keyword])
                        @else
                            @include('search::entries.default', ['entry' => $result])
                        @endif
                    @endforeach
                @endif
            </div>
        @endslot
    @endcomponent
@endsection
