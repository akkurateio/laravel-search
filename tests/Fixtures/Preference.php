<?php

namespace Akkurate\LaravelSearch\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $table = 'preferences';
    protected $fillable = ['target', 'pagination', 'language_id'];

    public function preferenceable()
    {
        return $this->morphTo();
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
