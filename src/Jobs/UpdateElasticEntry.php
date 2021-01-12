<?php

namespace Akkurate\LaravelSearch\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateElasticEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected object $model;
    protected string $doctype;
    protected string $route;

    /**
     * Create a new job instance.
     * @param $model
     * @param $doctype
     * @param $route
     *
     * @return void
     */
    public function __construct($model, $doctype, $route = '')
    {
        $this->model = $model;
        $this->doctype = $doctype;
        $this->route = $route;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (config('app.env') === 'testing') {
            return true;
        }

        if (!empty($this->route)) {
            $link = config("laravel-search.elastic.indexable.$this->doctype.link") == 'edit' ? '/edit' : '';
            $route = url('/') . "/{$this->route}" . $link;
        } else {
            $route = '#';
        }
        \Search::put($this->model->searchable->uuid, [
            "name" => $this->model->{config("laravel-search.elastic.indexable.$this->doctype.name")},
            "docType" => $this->doctype,
            "entities" => $this->model->getEntities(),
            "access" => $this->model->getAccess(),
            "suggest" => config("laravel-search.elastic.indexable.$this->doctype.suggest"),
            "content" => $this->model->getSearchContent(),
            "fields" => $this->model->getFiltersContent(),
            "links" => [
                [
                    "url" => $route,
                    "target" => '_self',
                    "environment" => 'BACK'
                ],
            ],
            "environments" => config("laravel-search.elastic.indexable.$this->doctype.env") ?? ['BACK']
        ]);
        $this->model->searchable->update([
            'name' => $this->model->{config("laravel-search.elastic.indexable.$this->doctype.name")}
        ]);
    }
}
