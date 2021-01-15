<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searchables', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->morphs('searchable');
            $table->nullableTimestamps();
        });
    }
}
