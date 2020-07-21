<?php

namespace BladeLibrary;

use BladeLibrary\Console\InstallCommand;
use BladeLibrary\Http\BladeLibraryController;
use BladeLibrary\Http\Components\FrontDesk;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Symfony\Component\Finder\Finder;

class BladeLibraryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerFacade();
        $this->registerComponentAutoDiscovery();

        $this->commands([
            InstallCommand::class,
        ]);
    }

    public function boot()
    {
        $this->registerConfig();
        $this->registerLivewireComponents();
        $this->registerBladeComponents();
        $this->registerBladeDirectives();
        $this->registerViews();
        $this->registerRoutes();
        $this->registerPublishables();
    }

    public function registerComponentAutoDiscovery()
    {
        $this->app->singleton(BladeLibraryComponentFinder::class, function () {
            return new BladeLibraryComponentFinder(
                new Finder,
                new Filesystem,
                config('blade-library.books_path', resource_path('views/books'))
            );
        });
    }

    protected function registerFacade()
    {
        $this->app->alias(BladeLibrary::class, 'blade-library');
    }

    protected function registerBladeComponents()
    {
        # code...
    }

    protected function registerBladeDirectives()
    {
        Blade::directive(BladeLibraryBladeDirectives::STORY_TAG, [BladeLibraryBladeDirectives::class, 'story']);
        Blade::directive('end'.BladeLibraryBladeDirectives::STORY_TAG, [BladeLibraryBladeDirectives::class, 'endstory']);
    }

    protected function registerLivewireComponents()
    {
        Livewire::component('blade-library', FrontDesk::class);
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'library');
        $this->loadViewsFrom(storage_path('blade-library'), 'library-generated');
    }

    protected function registerRoutes()
    {
        Route::get(config('blade-library.path', '/library'), [BladeLibraryController:: class, 'index'])
            ->middleware('web');
        Route::get(config('blade-library.path', '/library') . '/{book}/{chapter}', [BladeLibraryController:: class, 'get'])
            ->middleware('web');
    }

    protected function registerPublishables()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blade-library.php' => config_path('blade-library.php'),
            ], 'blade-library-config');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/blade-library'),
            ], 'blade-library-assets');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/blade-library'),
            ], 'blade-library-views');
        }
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-library.php', 'blade-library');
    }
}
