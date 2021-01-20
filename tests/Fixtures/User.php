<?php

namespace Akkurate\LaravelSearch\Tests\Fixtures;

use Akkurate\LaravelSearch\Traits\EloquentSearchable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Searchable
{
    use EloquentSearchable,
        hasRoles;

    protected $table = 'users';
    protected $fillable = ['account_id', 'preference_id'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'admin_account_user');
    }

    public function preference()
    {
        return $this->morphOne(Preference::class, 'preferenceable');
    }

    public function getSearchResult(): SearchResult
    {
    $url = route('search', [
        'uuid' => 'user',
        'token' => csrf_token()
    ]);

    return new \Spatie\Searchable\SearchResult(
        $this,
        $this->query,
        $url
    );
    }
}
