<?php

namespace Akkurate\LaravelSearch\Observers\Crm;

use Akkurate\LaravelCrm\Models\Company;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function created(Company  $company)
    {
        //
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function updated(Company  $company)
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function deleted(Company  $company)
    {
        //
    }

    /**
     * Handle the Company "forceDeleted" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function forceDeleted(Company  $company)
    {
        //
    }
}
