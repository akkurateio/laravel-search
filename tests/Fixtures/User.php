<?php

namespace Akkurate\LaravelSearch\Tests\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = ['account_id', 'preference_id'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function preference()
    {
        return $this->morphOne(Preference::class, 'preferenceable');
    }
}
