<?php

namespace Akkurate\LaravelSearch\Observers\Glossary;

use Akkurate\LaravelGlossary\Models\Term;
use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\DeleteElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;

class TermObserver
{
    /**
     * Handle the Term "created" event.
     *
     * @param  Term  $term
     * @return void
     */
    public function created(Term  $term)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if (! $term->searchable) {
            CreateElasticEntry::dispatch($term, 'GLOSSARY_TERM', "brain/{uuid}/glossary/terms/$term->slug");
        }
    }

    /**
     * Handle the Term "updated" event.
     *
     * @param  Term  $term
     * @return void
     */
    public function updated(Term  $term)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if ($term->searchable) {
            UpdateElasticEntry::dispatch($term, 'GLOSSARY_TERM', "brain/{uuid}/glossary/terms/$term->slug");
        } else {
            CreateElasticEntry::dispatch($term, 'GLOSSARY_TERM', "brain/{uuid}/glossary/terms/$term->slug");
        }
    }

    /**
     * Handle the Term "deleted" event.
     *
     * @param  Term  $term
     * @return void
     */
    public function deleted(Term  $term)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if (! empty($term->seachable)) {
            $uuidSearchable = $term->searchable->uuid;

            DeleteElasticEntry::dispatch($uuidSearchable);
            $term->searchable()->where('uuid', $uuidSearchable)->delete();
        }
    }

    /**
     * Handle the Term "forceDeleted" event.
     *
     * @param  Term  $term
     * @return void
     */
    public function forceDeleted(Term  $term)
    {
        //
    }
}
