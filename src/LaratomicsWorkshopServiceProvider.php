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
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laratomics-workshop.php', 'laratomics-workshop'
        );
    }
}