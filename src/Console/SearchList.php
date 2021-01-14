<?php

namespace Akkurate\LaravelSearch\Console;

use Illuminate\Console\Command;

class SearchList extends Command
{
    protected $signature = 'search:list';
    protected $description = 'List the observable models that should be sent in Elastic';

    public function handle()
    {
        $models = [];
        foreach (config('laravel-search.elastic.indexable') as $model) {
            if ($model['index']) {
                $models[] = $model;
            }
        }
        if (! $models) {
            $this->info('No model observed at the moment.');
        } else {
            $plural = count($models) > 1 ? 's' : '';
            $this->info(count($models) . ' model' . $plural .' observed:');
            foreach ($models as $observable) {
                $suggest = $observable['suggest'] ? '(suggest)' : '';
                $this->warn('• ' . $observable['model'] . ' ' . $suggest);
            }
        }
    }
}
