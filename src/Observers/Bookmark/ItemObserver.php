<?php

namespace Akkurate\LaravelSearch\Observers\Bookmark;

use Akkurate\LaravelBookmark\Models\Item;
use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\DeleteElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     *
     * @param  Item  $item
     * @return void
     */
    public function created(Item  $item)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if (! $item->searchable) {
            CreateElasticEntry::dispatch($item, 'BOOKMARK_ITEM', "brain/{uuid}/bookmark/items/$item->id");
        }
    }

    /**
     * Handle the Item "updated" event.
     *
     * @param  Item  $item
     * @return void
     */
    public function updated(Item  $item)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if ($item->searchable) {
            UpdateElasticEntry::dispatch($item, 'BOOKMARK_ITEM', "brain/{uuid}/bookmark/items/$item->id");
        } else {
            CreateElasticEntry::dispatch($item, 'BOOKMARK_ITEM', "brain/{uuid}/bookmark/items/$item->id");
        }
    }

    /**
     * Handle the Item "deleted" event.
     *
     * @param  Item  $item
     * @return void
     */
    public function deleted(Item  $item)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if (! empty($item->seachable)) {
            $uuidSearchable = $item->searchable->uuid;

            DeleteElasticEntry::dispatch($uuidSearchable);
            $item->searchable()->where('uuid', $uuidSearchable)->delete();
        }
    }

    /**
     * Handle the Item "forceDeleted" event.
     *
     * @param  Item  $item
     * @return void
     */
    public function forceDeleted(Item  $item)
    {
        //
    }
}
