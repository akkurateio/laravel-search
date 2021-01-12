<?php

namespace Akkurate\LaravelSearch\Observers\Media;

use Akkurate\LaravelMedia\Models\Resource;

class ResourceObserver
{
    /**
     * Handle the Resource "created" event.
     *
     * @param  Resource  $resource
     * @return void
     */
    public function created(Resource  $resource)
    {
        //
    }

    /**
     * Handle the Resource "updated" event.
     *
     * @param  Resource  $resource
     * @return void
     */
    public function updated(Resource  $resource)
    {
        //
    }

    /**
     * Handle the Resource "deleted" event.
     *
     * @param  Resource  $resource
     * @return void
     */
    public function deleted(Resource  $resource)
    {
        //
    }

    /**
     * Handle the Resource "forceDeleted" event.
     *
     * @param  Resource  $resource
     * @return void
     */
    public function forceDeleted(Resource  $resource)
    {
        //
    }
}
