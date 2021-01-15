<?php

namespace Akkurate\LaravelSearch;

use Akkurate\LaravelSearch\Console\SearchCheck;
use Akkurate\LaravelSearch\Console\SearchClear;
use Akkurate\LaravelSearch\Console\SearchList;
use Akkurate\LaravelSearch\Console\SearchMakeObserver;
use Akkurate\LaravelSearch\Console\SearchQuery;
use Akkurate\LaravelSearch\Console\SearchSync;
use Illuminate\Support\ServiceProvider;

/**
 * Access service provider
 *
 */
class LaravelSearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('laravel-search.elastic.enabled')) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
            $this->loadRoutesFrom(__DIR__.'/../routes/elastic.php');
            foreach (config('laravel-search.elastic.indexable') as $model) {
                if ($model['index']) {
                    $model['model']::observe($model['observer']);
                }
            }
            if ($this->app->runningInConsole()) {
                $this->commands([
                    SearchCheck::class,
                    SearchMakeObserver::class,
                    SearchList::class,
                    SearchSync::class,
                    SearchQuery::class,
                    SearchClear::class
                ]);
            }
        } else {
            $this->loadRoutesFrom(__DIR__.'/../routes/eloquent.php');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'search');

        $this->publishes([
            __DIR__.'/../config/laravel-search.php' => config_path('laravel-search.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/search'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../resources/views/partials/akk4search.blade.php' => resource_path('views/vendor/search/partials/akk4search.blade.php'),
        ], 'akk4search');

        $this->publishes([
            __DIR__.'/../resources/views/entries' => resource_path('views/vendor/search/entries'),
        ], 'entries');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-search.php',
            'laravel-search'
        );

        if (config('laravel-search.elastic.enabled')) {
            $this->app->bind('akkurate-for-search', function () {
                return new \Akkurate4Search\Content(config('laravel-search.elastic.credentials.key'));
            });
        }
    }
}
