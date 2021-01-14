<?php

namespace Akkurate\LaravelSearch\Console;

use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;
use Illuminate\Console\Command;

class SearchSync extends Command
{
    protected $signature = 'search:sync';
    protected $description = 'Synchronize the data between the app and Elastic';

    public function handle()
    {
        if (! \Search::getToken()) {
            $this->info("No connection to akk4search :'(");
            $this->warn("Check your key and your IP address");

            return;
        }
        foreach (config('laravel-search.elastic.indexable') as $doctype => $model) {
            if ($model['index']) {
                if (! empty($model['where'])) {
                    $items = $model['model']::where($model['where'])->get();
                } else {
                    $items = $model['model']::all();
                }
                $bar = $this->output->createProgressBar(count($items));
                $this->warn('Synchronizing doctype ' . $doctype);
                $bar->start();
                foreach ($items as $item) {
                    if (! empty($model['route'])) {
                        $key = isset($model['key']) ? $model['key'] : 'id';
                        $route = $model['route']."/{$item->$key}";
                    } else {
                        $route = '';
                    }
                    if ($item->searchable) {
                        UpdateElasticEntry::dispatch($item, $doctype, $route, $item->getSearchContent());
                    } else {
                        CreateElasticEntry::dispatch($item, $doctype, $route, $item->getSearchContent());
                    }
                    $bar->advance();
                }
                $bar->finish();
                $this->warn(' ' . $doctype . ' synchronized');
            }
        }
        $this->info('Synchronization complete!');
    }
}
