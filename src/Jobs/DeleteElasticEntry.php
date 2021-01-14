<?php

namespace Akkurate\LaravelSearch\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteElasticEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uuidSearchable;

    /**
     * Create a new job instance.
     * @param $uuidSearchable
     */
    public function __construct($uuidSearchable)
    {
        $this->uuidSearchable = $uuidSearchable;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (config('app.env', 'production') !== 'testing') {
            \Search::delete($this->uuidSearchable);
        }
    }
}
