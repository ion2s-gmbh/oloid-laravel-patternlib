<?php

namespace Ion2s\Laratomics;

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
//        $this->setPublishing();

        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'laratomics-workshop'
        );
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
     * Get the basic route configuration.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace' => 'Ion2s\Laratomics\Http\Controllers',
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
     * Publish package's configs and views.
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
            __DIR__.'/../resources/views' => resource_path('views/vendor/ion2s/laratomics-workshop'),
        ], 'laratomics-views');

        /*
         * Publish languages/translations
         */
//        $this->publishes([
//            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/ion2s/laratomics-workshop')
//        ], 'laratomics-lang');
    }
}