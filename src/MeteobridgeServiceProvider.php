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
        $this->registerConsoleCommands();
    }

    /**
     * Setup migrations
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
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
}
