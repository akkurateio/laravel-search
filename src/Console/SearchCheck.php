<?php

namespace Akkurate\LaravelSearch\Console;

use Illuminate\Console\Command;

class SearchCheck extends Command
{
    protected $signature = 'search:check';
    protected $description = 'Check the connection with Elastic';

    public function handle()
    {
        if (\Search::getToken()) {
            $this->info('Connected to akk4search with key:');
            $this->warn(config('laravel-search.elastic.credentials.key'));
        } else {
            $this->info("No connection to akk4search :'(");
            $this->warn("Check your key and your IP address");
        }
    }
}
