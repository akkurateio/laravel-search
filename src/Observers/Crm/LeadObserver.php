<?php

namespace Akkurate\LaravelSearch\Observers\Crm;

use Akkurate\LaravelCrm\Models\Lea;

class LeadObserver
{
    /**
     * Handle the Lead "created" event.
     *
     * @param  Lead  $lead
     * @return void
     */
    public function created(Lead  $lead)
    {
        //
    }

    /**
     * Handle the Lead "updated" event.
     *
     * @param  Lead  $lead
     * @return void
     */
    public function updated(Lead  $lead)
    {
        //
    }

    /**
     * Handle the Lead "deleted" event.
     *
     * @param  Lead  $lead
     * @return void
     */
    public function deleted(Lead  $lead)
    {
        //
    }

    /**
     * Handle the Lead "forceDeleted" event.
     *
     * @param  Lead  $lead
     * @return void
     */
    public function forceDeleted(Lead  $lead)
    {
        //
    }
}
