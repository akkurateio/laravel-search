<?php

namespace Akkurate\LaravelSearch\Observers\Blog;

use Akkurate\LaravelBlog\Models\Article;
use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\DeleteElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     *
     * @param  Article  $article
     * @return void
     */
    public function created(Article  $article)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if (! $article->searchable) {
            CreateElasticEntry::dispatch($article, 'BLOG_ARTICLE', "brain/{uuid}/blog/articles/$article->slug");
        }
    }

    /**
     * Handle the Article "updated" event.
     *
     * @param  Article  $article
     * @return void
     */
    public function updated(Article  $article)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if ($article->searchable) {
            UpdateElasticEntry::dispatch($article, 'BLOG_ARTICLE',  "brain/{uuid}/blog/articles/$article->slug");
        } else {
            CreateElasticEntry::dispatch($article, 'BLOG_ARTICLE', "brain/{uuid}/blog/articles/$article->slug");
        }
    }

    /**
     * Handle the Article "deleted" event.
     *
     * @param  Article  $article
     * @return void
     */
    public function deleted(Article  $article)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing') {
            return;
        }
        if (! empty($article->seachable)) {
            $uuidSearchable = $article->searchable->uuid;

            DeleteElasticEntry::dispatch($uuidSearchable);
            $article->searchable()->where('uuid', $uuidSearchable)->delete();
        }
    }

    /**
     * Handle the Article "forceDeleted" event.
     *
     * @param  Article  $article
     * @return void
     */
    public function forceDeleted(Article  $article)
    {
        //
    }
}
