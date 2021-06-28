<?php

namespace TromsFylkestrafikk\Meteobridge;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use TromsFylkestrafikk\Meteobridge\Console\StationAdd;
use TromsFylkestrafikk\Meteobridge\Console\StationDelete;
use TromsFylkestrafikk\Meteobridge\Console\StationList;
use TromsFylkestrafikk\Meteobridge\Console\StationSetParam;

class MeteobridgeServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerMigrations();
        $this->registerConfig();
        $this->registerConsoleCommands();
        $this->registerRoutes();
    }

    /**
     * Setup migrations
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function registerConfig()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/meteobridge.php' =>  config_path('meteobridge.php')
            ], 'config');
        }
    }

    /**
     * Setup Artisan console commands.
     */
    protected function registerConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StationAdd::class,
                StationDelete::class,
                StationList::class,
                StationSetParam::class,
            ]);
        }
    }

    /**
     * Setup routes utilized by meteobridge.
     */
    protected function registerRoutes()
    {
        $routeAttrs = config('meteobridge.route_attributes', ['prefix' => 'meteobridge', 'middleware' => ['api']]);
        Route::group($routeAttrs, function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }
}
