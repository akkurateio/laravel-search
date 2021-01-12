<?php

namespace Akkurate\LaravelSearch\Observers\Faq;

use Akkurate\LaravelFaq\Models\Question;
use Akkurate\LaravelSearch\Jobs\CreateElasticEntry;
use Akkurate\LaravelSearch\Jobs\UpdateElasticEntry;
use Akkurate\LaravelSearch\Jobs\DeleteElasticEntry;

class QuestionObserver
{
    /**
     * Handle the Question "created" event.
     *
     * @param  Question  $question
     * @return void
     */
    public function created(Question  $question)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if (!$question->searchable) {
            CreateElasticEntry::dispatch($question, 'FAQ_QUESTION', "brain/{uuid}/faq/questions/$question->id/edit");
        }
    }

    /**
     * Handle the Question "updated" event.
     *
     * @param  Question  $question
     * @return void
     */
    public function updated(Question  $question)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if ($question->searchable) {
            UpdateElasticEntry::dispatch($question, 'FAQ_QUESTION', "brain/{uuid}/faq/questions/$question->id/edit");
        }   else {
            CreateElasticEntry::dispatch($question, 'FAQ_QUESTION', "brain/{uuid}/faq/questions/$question->id/edit");
        }
    }

    /**
     * Handle the Question "deleted" event.
     *
     * @param  Question  $question
     * @return void
     */
    public function deleted(Question  $question)
    {
        if (app()->runningInConsole() || config('app.env') === 'testing')
        {
            return;
        }
        if (!empty($question->seachable)) {
            $uuidSearchable = $question->searchable->uuid;

            DeleteElasticEntry::dispatch($uuidSearchable);
            $question->searchable()->where('uuid', $uuidSearchable)->delete();
        }
    }

    /**
     * Handle the Question "forceDeleted" event.
     *
     * @param  Question  $question
     * @return void
     */
    public function forceDeleted(Question  $question)
    {
        //
    }
}
