<?php

namespace Akkurate\LaravelSearch\Traits;

/**
 * Trait EloquentSearchable
 */
trait EloquentSearchable {


    /**
     * Scope a query to only include resources from user account (unless superadmin).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEloquentSearchable($query)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return $query
                ->where('account_id', auth()->user()->account_id)
                ->orWhereIn('account_id', auth()->user()->accounts->pluck('id'));
        }
    }

}
