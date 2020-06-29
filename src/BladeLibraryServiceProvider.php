<?php

namespace BladeLibrary;

use BladeLibrary\Http\BladeLibraryController;
use BladeLibrary\Http\Components\FrontDesk;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class BladeLibraryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerFacade();
    }

    public function boot()
    {
        $this->registerConfig();
        $this->registerLivewireComponents();
        $this->registerBladeComponents();
        $this->registerViews();
        $this->registerRoutes();
        $this->registerPublishables();
    }

    protected function registerFacade()
    {
        $this->app->alias(BladeLibrary::class, 'blade-library');
    }

    protected function registerBladeComponents()
    {
        # code...
    }

    protected function registerLivewireComponents()
    {
        Livewire::component('blade-library', FrontDesk::class);
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'library');
    }

    protected function registerRoutes()
    {
        Route::get(config('blade-library.path', '/library'), [BladeLibraryController:: class, 'index']);
    }

    protected function registerPublishables()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blade-library.php' => config_path('blade-library.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/blade-library'),
            ], 'views');
        }
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-library.php', 'blade-library');
    }
}
