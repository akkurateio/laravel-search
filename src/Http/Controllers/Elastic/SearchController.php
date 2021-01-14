<?php

namespace Akkurate\LaravelSearch\Http\Controllers\Elastic;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

//    public function searchAll($searchword)
//    {
//        $results = \Search::search(request()->headers->get('environment'), $searchword, null, [auth()->user()->uuid]);
//        return json_encode($results);
//    }
//
//    public function searchEntity($entity_uuid)
//    {
//        $results = \Search::search(request()->headers->get('environment'), null, $entity_uuid, [auth()->user()->uuid]);
//        return json_encode($results);
//    }

    /**
     * Launch this research inside of Elastic database when the customer press "Enter" key on his keyboard.
     *
     * @param Request $request
     * @param $uuid
     * @param $searchword
     * @param $filters
     * @return Application
     */
    public function submit(Request $request, $uuid, $searchword, $filters = null)
    {
        $data = \Search::search('BACK', $searchword, null, $filters, $request->get('filters'), [
            "pagination" => true,
            "from" => intval($request->from),
            "limit" => config('laravel-search.pagination')
        ]);
        if (! empty($data->statusCode) && $data->statusCode === 400) {
            return back()->withError('Aucune entrée ne correspond dans notre base');
        }

        return view('search::pages.results', [
            'keyword' => $searchword,
            'suggestions' => $data->suggestions,
            'results' => $data->results,
            'from' => $data->meta->page,
            'total' => $data->meta->total,
            'pages' => number_format(ceil($data->meta->total / config('laravel-search.pagination')), 0),
            'current' => number_format(round($data->meta->page / config('laravel-search.pagination')), 0),
            'before' => $data->meta->page - config('laravel-search.pagination') * 2,
        ]);
    }
}
