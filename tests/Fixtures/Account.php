<?php

namespace Akkurate\LaravelSearch\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Account extends Model
{

    protected $table = 'accounts';

    protected $fillable = ['name', 'slug', 'email', 'preference_id'];


    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function preference()
    {
        return $this->belongsTo(Preference::class);
    }
}
