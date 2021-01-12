<?php

Route::group([
    'middleware' => config('laravel-search.middleware'),
    'prefix' => config('laravel-search.prefix')], function () {
//    Route::post('search/entity/{entity_uuid}', [\Akkurate\LaravelSearch\Http\Controllers\SearchController::class, 'searchEntity'])
//        ->name('search.entity')
//        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
//    Route::post('search/{searchword}', [\Akkurate\LaravelSearch\Http\Controllers\SearchController::class, 'searchAll'])
//        ->name('search.all')
//        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('search/{searchword}', [\Akkurate\LaravelSearch\Http\Controllers\Elastic\SearchController::class, 'submit'], ['from' => request('from')])
        ->name('search.submit');
    Route::post('search', [\Akkurate\LaravelSearch\Http\Controllers\Elastic\SearchController::class, 'search'])->name('search');
});
