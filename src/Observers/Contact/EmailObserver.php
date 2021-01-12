<?php

namespace Akkurate\LaravelSearch\Observers\Contact;

use Akkurate\LaravelContact\Models\Email;

class EmailObserver
{
    /**
     * Handle the Email "created" event.
     *
     * @param  Email  $email
     * @return void
     */
    public function created(Email  $email)
    {
        //
    }

    /**
     * Handle the Email "updated" event.
     *
     * @param  Email  $email
     * @return void
     */
    public function updated(Email  $email)
    {
        //
    }

    /**
     * Handle the Email "deleted" event.
     *
     * @param  Email  $email
     * @return void
     */
    public function deleted(Email  $email)
    {
        //
    }

    /**
     * Handle the Email "forceDeleted" event.
     *
     * @param  Email  $email
     * @return void
     */
    public function forceDeleted(Email  $email)
    {
        //
    }
}
