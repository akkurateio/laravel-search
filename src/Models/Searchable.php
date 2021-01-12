<?php

namespace Akkurate\LaravelSearch\Models;

use Illuminate\Database\Eloquent\Model;

class Searchable extends Model
{
    protected $table = 'searchables';
    protected $fillable = ['uuid','name','model_type','model_id'];
}
