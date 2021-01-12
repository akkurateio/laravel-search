<?php

namespace Akkurate\LaravelSearch\Console;

use Akkurate\LaravelSearch\Models\Searchable;
use Illuminate\Console\Command;

class SearchClear extends Command
{
    protected $signature = 'search:clear {--entities=*} {--all} {--sync}';
    protected $description = 'Remove useless data from Elastic database';

    public function handle()
    {
        if (!\Search::getToken()) {
            $this->info("No connection to akk4search :'(");
            $this->warn("Check your key and your IP address");
            return;
        }
        if ($this->option('all')) {
            $delete = \Search::deleteAll();
            $searchables = Searchable::all();
            foreach ($searchables as $searchable) {
                $searchable->delete();
            }
            if ($delete === true) {
                $this->info('Data cleared!');
            } else {
                dump($delete);
            }
        } elseif ($entities = $this->option('entities')) {
            foreach ($entities as $entity) {
                $delete = \Search::deleteAll($entity);
                if ($delete === true) {
                    $this->info($entity.' deleted!');
                    $this->warn('You still have to remove related searchables in SQL database');
                } else {
                    dump($delete);
                }
            }
        } else {
            foreach (config('laravel-search.elastic.indexable') as $doctype => $model) {
                if ($model['index']) {
                    $delete = \Search::deleteAll($doctype);
                    if ($delete === true) {
                        $observables = $model['model']::all();
                        foreach ($observables as $observable) {
                            if ($observable->searchable) {
                                $observable->searchable->delete();
                            }
                        }
                        $this->info($doctype . ' deleted!');
                    } else {
                        dump($delete);
                    }
                }
            }
        }
        if ($this->option('sync')) {
            $this->call('search:sync');
        }
    }
}