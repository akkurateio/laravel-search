<?php

namespace Akkurate\LaravelSearch\Observers\Helpdesk;

use Akkurate\LaravelHelpdesk\Models\Category;

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
        //
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function updated(Category  $category)
    {
        //
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function deleted(Category  $category)
    {
        //
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
