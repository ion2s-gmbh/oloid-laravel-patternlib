<?php

namespace Laratomics;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laratomics\Console\Commands\CleanCommand;
use Laratomics\Console\Commands\InstallCommand;
use Laratomics\Console\Commands\ReconfigureCommand;

class WorkshopServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setRoutes();
        $this->setViews();
    }

    /**
     * Set the package's routes.
     */
    private function setRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Set the package's views.
     */
    private function setViews()
    {
        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'workshop'
        );
    }

    /**
     * Get the basic route configuration.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace' => 'Laratomics\Http\Controllers',
            'prefix' => config('workshop.uri')
        ];
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->publishFiles();
        $this->registerCommands();
    }

    /**
     * Merge configurations.
     */
    private function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/workshop.php', 'workshop'
        );
    }

    /**
     * Publish package's configs, views and assets.
     */
    private function publishFiles()
    {
        /*
         * Publish configs
         */
        $this->publishes([
            __DIR__ . '/../config/workshop.php' => config_path('workshop.php')
        ], 'workshop-config');

        /*
         * Publish views
         */
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/workshop'),
        ], 'workshop-views');

        /*
         * Publish assets
         */
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/workshop')
        ], 'workshop-assets');
    }

    private function registerCommands()
    {
        $this->commands([
            InstallCommand::class,
            CleanCommand::class,
            ReconfigureCommand::class,
        ]);
    }
}