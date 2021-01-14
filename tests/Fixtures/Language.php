<?php

namespace Akkurate\LaravelSearch\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Language extends Model
{

    protected $table = 'languages';

    protected $fillable = ['label', 'locale', 'locale_php', 'priority', 'is_active', 'is_default'];

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

}
