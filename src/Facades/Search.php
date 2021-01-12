<?php

namespace Akkurate\LaravelSearch\Facades;

use Illuminate\Support\Facades\Facade;

class Search extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'akkurate-for-search';
    }
}