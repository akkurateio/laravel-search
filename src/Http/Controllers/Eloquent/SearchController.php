<?php

namespace Akkurate\LaravelSearch\Http\Controllers\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

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

    public function search(Request $request)
    {
        $search = new Search();

        foreach (config('laravel-search.eloquent.searchable') as $searchable)   {
            $search->registerModel($searchable['model'], function(ModelSearchAspect $modelSearchAspect) use ($searchable) {
                foreach ($searchable['attributes'] as $attribute) {
                    $modelSearchAspect->addSearchableAttribute($attribute);
                }
                if  ($searchable['model'] == "Akkurate\LaravelCore\Models\Account") {
                    $modelSearchAspect->administrable();
                } else {
                    $modelSearchAspect->eloquentSearchable();
                }
            });
        }

        $searchResults = $search->search($request->input('query'));

        return view('search::pages.eloquent-results', compact('searchResults'));
    }
}
