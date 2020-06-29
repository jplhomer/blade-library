<?php

namespace Woodblock;

use Illuminate\Support\ServiceProvider;

class WoodblockServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/woodblock.php' => config_path('woodblock.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/woodblock'),
            ], 'views');
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'woodblock');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/woodblock.php', 'woodblock');
    }
}
