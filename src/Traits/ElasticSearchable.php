<?php

namespace Akkurate\LaravelSearch\Traits;

use Illuminate\Support\Str;
use Akkurate\LaravelSearch\Models\Searchable;

/**
 * Trait ElasticSearchable
 */
trait ElasticSearchable {

    public function searchable()
    {
        return $this->morphOne(Searchable::class, 'searchable');
    }

    public function getDoctypeAttribute()
    {
        return Str::upper(Str::snake(class_basename(get_class($this))));
    }

    public function getEntities()
    {
        return [];
    }

    public function getAccess()
    {
        return [];
    }

    public function getSearchContent()
    {
        return [$this->toJson()];
    }

    public function getFiltersContent()
    {

    }
}
