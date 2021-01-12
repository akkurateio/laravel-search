<?php

namespace Akkurate\LaravelSearch\Observers\Bookmark;

use Akkurate\LaravelBookmark\Models\Category;
use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\DeleteElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function created(Category  $category)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if (!$category->searchable) {
            CreateElasticEntry::dispatch($category, 'BOOKMARK_CATEGORY', "brain/{uuid}/bookmark/categories/$category->id");
        }
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function updated(Category  $category)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if ($category->searchable) {
            UpdateElasticEntry::dispatch($category, 'BOOKMARK_CATEGORY', "brain/{uuid}/bookmark/categories/$category->id");
        } else {
            CreateElasticEntry::dispatch($category, 'BOOKMARK_CATEGORY', "brain/{uuid}/bookmark/categories/$category->id");
        }
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function deleted(Category  $category)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if (!empty($category->seachable)) {
            $uuidSearchable = $category->searchable->uuid;

            DeleteElasticEntry::dispatch($uuidSearchable);
            $category->searchable()->where('uuid', $uuidSearchable)->delete();
        }
    }

    /**
     * Handle the Category "forceDeleted" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function forceDeleted(Category  $category)
    {
        //
    }
}
