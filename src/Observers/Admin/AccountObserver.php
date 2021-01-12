<?php

namespace Akkurate\LaravelSearch\Observers\Admin;

use Akkurate\LaravelCore\Models\Account;
use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;
use Akkurate\LaravelSearch\Jobs\DeleteElasticEntry;

class AccountObserver
{
    /**
     * Handle the Account "created" event.
     *
     * @param  Account  $account
     * @return void
     */
    public function created(Account  $account)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if (!$account->searchable) {
            CreateElasticEntry::dispatch($account, 'ADMIN_ACCOUNT');
        }
    }

    /**
     * Handle the Account "updated" event.
     *
     * @param  Account  $account
     * @return void
     */
    public function updated(Account  $account)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if ($account->searchable) {
            UpdateElasticEntry::dispatch($account, 'ADMIN_ACCOUNT');
        } else {
            CreateElasticEntry::dispatch($account, 'ADMIN_ACCOUNT');
        }
    }

    /**
     * Handle the Account "deleted" event.
     *
     * @param  Account  $account
     * @return void
     */
    public function deleted(Account  $account)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        $uuidSearchable = $account->searchable->uuid;

        DeleteElasticEntry::dispatch($uuidSearchable);
        $account->searchable()->where('uuid', $uuidSearchable)->delete();
    }

    /**
     * Handle the Account "forceDeleted" event.
     *
     * @param  Account  $account
     * @return void
     */
    public function forceDeleted(Account  $account)
    {
        //
    }

}
