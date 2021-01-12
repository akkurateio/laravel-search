<?php

namespace Akkurate\LaravelSearch\Observers\Contact;

use Akkurate\LaravelContact\Models\Phone;

class PhoneObserver
{
    /**
     * Handle the Phone "created" event.
     *
     * @param  Phone  $phone
     * @return void
     */
    public function created(Phone  $phone)
    {
        //
    }

    /**
     * Handle the Phone "updated" event.
     *
     * @param  Phone  $phone
     * @return void
     */
    public function updated(Phone  $phone)
    {
        //
    }

    /**
     * Handle the Phone "deleted" event.
     *
     * @param  Phone  $phone
     * @return void
     */
    public function deleted(Phone  $phone)
    {
        //
    }

    /**
     * Handle the Phone "forceDeleted" event.
     *
     * @param  Phone  $phone
     * @return void
     */
    public function forceDeleted(Phone  $phone)
    {
        //
    }
}
