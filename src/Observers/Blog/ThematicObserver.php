<?php

namespace Akkurate\LaravelSearch\Observers\Blog;

use Akkurate\LaravelBlog\Models\Thematic;
use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\DeleteElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;

class ThematicObserver
{
    /**
     * Handle the Thematic "created" event.
     *
     * @param  Thematic  $thematic
     * @return void
     */
    public function created(Thematic  $thematic)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if (!$thematic->searchable) {
            CreateElasticEntry::dispatch($thematic, 'BLOG_THEMATIC', "brain/{uuid}/blog/thematics/$thematic->slug");
        }

    }

    /**
     * Handle the Thematic "updated" event.
     *
     * @param  Thematic  $thematic
     * @return void
     */
    public function updated(Thematic  $thematic)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if ($thematic->searchable) {
            UpdateElasticEntry::dispatch($thematic, 'BLOG_THEMATIC', "brain/{uuid}/blog/thematics/$thematic->slug");
        } else {
            CreateElasticEntry::dispatch($thematic, 'BLOG_THEMATIC', "brain/{uuid}/blog/thematics/$thematic->slug");
        }
    }

    /**
     * Handle the Thematic "deleted" event.
     *
     * @param  Thematic  $thematic
     * @return void
     */
    public function deleted(Thematic  $thematic)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if (!empty($thematic->seachable)) {
            $uuidSearchable = $thematic->searchable->uuid;

            DeleteElasticEntry::dispatch($uuidSearchable);
            $thematic->searchable()->where('uuid', $uuidSearchable)->delete();
        }
    }

    /**
     * Handle the Thematic "forceDeleted" event.
     *
     * @param  Thematic  $thematic
     * @return void
     */
    public function forceDeleted(Thematic  $thematic)
    {
        //
    }
}
