<?php

namespace Akkurate\LaravelSearch\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
