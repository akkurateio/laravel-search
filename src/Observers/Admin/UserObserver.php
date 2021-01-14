<?php

namespace Akkurate\LaravelSearch\Observers\Admin;

use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\DeleteElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if (! $user->searchable) {
            CreateElasticEntry::dispatch($user, 'ADMIN_USER', "brain/{uuid}/admin/users/$user->id", $user->getSearchContent());
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if ($user->searchable) {
            UpdateElasticEntry::dispatch($user, 'ADMIN_USER', "brain/{uuid}/admin/users/$user->id", $user->getSearchContent());
        } else {
            CreateElasticEntry::dispatch($user, 'ADMIN_USER', "brain/{uuid}/admin/users/$user->id", $user->getSearchContent());
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if (! empty($user->seachable)) {
            $uuidSearchable = $user->searchable->uuid;

            DeleteElasticEntry::dispatch($uuidSearchable);
            $user->searchable()->where('uuid', $uuidSearchable)->delete();
        }
    }

    /**
     * Handle the User "forceDeleted" event.
     *
     * @param  User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
