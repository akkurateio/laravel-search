<?php

namespace Akkurate\LaravelSearch\Observers\Documentation;

use Akkurate\LaravelDocumentation\Models\Page;

class PageObserver
{
    /**
     * Handle the Page "created" event.
     *
     * @param  Page  $page
     * @return void
     */
    public function created(Page  $page)
    {
        //
    }

    /**
     * Handle the Page "updated" event.
     *
     * @param  Page  $page
     * @return void
     */
    public function updated(Page  $page)
    {
        //
    }

    /**
     * Handle the Page "deleted" event.
     *
     * @param  Page  $page
     * @return void
     */
    public function deleted(Page  $page)
    {
        //
    }

    /**
     * Handle the Page "forceDeleted" event.
     *
     * @param  Page  $page
     * @return void
     */
    public function forceDeleted(Page  $page)
    {
        //
    }
}
