<?php

namespace TomatoPHP\TomatoApi;

use Illuminate\Support\ServiceProvider;
use TomatoPHP\TomatoApi\Console\CreateApiCrudCommand;


class TomatoApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\TomatoApi\Console\TomatoApiInstall::class,
            CreateApiCrudCommand::class
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/tomato-api.php', 'tomato-api');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/tomato-api.php' => config_path('tomato-api.php'),
        ], 'config');

    }

    public function boot(): void
    {
        //you boot methods here
    }
}
