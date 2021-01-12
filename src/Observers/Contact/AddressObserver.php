<?php

namespace Akkurate\LaravelSearch\Observers\Contact;

use Akkurate\LaravelContact\Models\Address;

class AddressObserver
{
    /**
     * Handle the Address "created" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function created(Address  $address)
    {
        //
    }

    /**
     * Handle the Address "updated" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function updated(Address  $address)
    {
        //
    }

    /**
     * Handle the Address "deleted" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function deleted(Address  $address)
    {
        //
    }

    /**
     * Handle the Address "forceDeleted" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function forceDeleted(Address  $address)
    {
        //
    }
}
