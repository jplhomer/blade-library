<?php

namespace BladeLibrary;

use Illuminate\Support\ServiceProvider;

class BladeLibraryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blade-library.php' => config_path('blade-library.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/blade-library'),
            ], 'views');
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blade-library');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-library.php', 'blade-library');
    }
}
