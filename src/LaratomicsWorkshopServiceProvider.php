<?php

namespace Laratomics;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class LaratomicsWorkshopServiceProvider extends BaseServiceProvider
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
            __DIR__.'/../resources/views', 'laratomics-workshop'
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
            'prefix' => config('laratomics-workshop.path')
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

    }

    /**
     * Merge configurations.
     */
    private function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laratomics-workshop.php', 'laratomics-workshop'
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
            __DIR__ . '/../config/laratomics-workshop.php' => config_path('laratomics-workshop.php')
        ], 'laratomics-config');

        /*
         * Publish views
         */
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laratomics-workshop'),
        ], 'laratomics-views');

        /*
         * Publish assets
         */
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/laratomics-workshop')
        ], 'laratomics-assets');
    }
}