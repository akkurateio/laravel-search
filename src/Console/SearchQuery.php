<?php

namespace Akkurate\LaravelSearch\Console;

use Illuminate\Console\Command;

class SearchQuery extends Command
{
    protected $signature = 'search:query {string} {--env=}';
    protected $description = 'Perform query in Elastic';

    public function handle()
    {
        if (\Search::getToken()) {
            dd(\Search::search($this->option('env') ?? 'BACK', $this->argument('string')));
        } else {
            $this->info("No connection to akk4search :'(");
            $this->warn("Check your key and your IP address");
        }
    }
}