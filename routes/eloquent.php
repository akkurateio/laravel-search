<?php

Route::group([
        'middleware' => config('laravel-search.middleware'),
        'prefix' => config('laravel-search.prefix')], function () {
    Route::post('search', [\Akkurate\LaravelSearch\Http\Controllers\Eloquent\SearchController::class, 'search'])->name('search');
});
