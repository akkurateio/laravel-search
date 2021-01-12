<?php

namespace Akkurate\LaravelSearch\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SearchMakeObserver extends Command
{
    protected $signature = 'search:make:observer {model} {--namespace=}';
    protected $description = 'Create an Observer for Akkurate Laravel Search';

    public function handle()
    {
        $model = $this->argument('model');
        if (!is_dir($folder = app_path("/Observers"))) {
            File::makeDirectory($folder);
        }
        file_put_contents(app_path("Observers/{$model}Observer.php"), str_replace(
            [
                '{{doctype}}',
                '{{namespace}}',
                '{{Model}}',
                '{{modelCamel}}',
            ],
            [
                Str::upper($model),
                $this->option('namespace') ? Str::ucfirst($this->option('namespace')).'\\' : 'App\\Models\\',
                $model,
                Str::camel($model)
            ],
            file_get_contents(__DIR__."/../stubs/observer.stub")
        ));
        $this->info('Observer created successfully');
    }
}